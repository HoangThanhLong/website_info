<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portfolio cá nhân và các dự án nổi bật">
    <title>@yield('title', $profile?->full_name ?? 'Portfolio')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project-preview.css') }}">
</head>
<body class="site-body">
    @if (session('success'))<div class="toast">{{ session('success') }}</div>@endif
    @yield('content')
    <script>
        const menuButton = document.querySelector('[data-menu]');
        menuButton?.addEventListener('click', () => document.querySelector('[data-nav]')?.classList.toggle('open'));

        const projectAnimations = new Map();
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function resetProjectImage(image) {
            const animation = projectAnimations.get(image);
            if (!animation) return;
            animation.pause();
            animation.currentTime = 0;
        }

        function bindProjectImageHover(image) {
            const frame = image.closest('.project-image');
            if (!frame || frame.dataset.previewBound) return;

            frame.dataset.previewBound = 'true';
            frame.addEventListener('mouseenter', () => projectAnimations.get(image)?.play());
            frame.addEventListener('mouseleave', () => resetProjectImage(image));
            frame.addEventListener('focusin', () => projectAnimations.get(image)?.play());
            frame.addEventListener('focusout', event => {
                if (!frame.contains(event.relatedTarget)) resetProjectImage(image);
            });
        }

        function animateProjectImage(image) {
            const frame = image.closest('.project-image');
            if (!frame || !image.naturalWidth || !image.naturalHeight) return;

            projectAnimations.get(image)?.cancel();
            projectAnimations.delete(image);
            image.classList.remove('project-image-cover');
            image.style.transform = 'translateY(0)';

            const renderedHeight = image.naturalHeight * (frame.clientWidth / image.naturalWidth);
            const overflow = renderedHeight - frame.clientHeight;

            if (overflow <= 8) {
                image.classList.add('project-image-cover');
                return;
            }

            if (reduceMotion) return;

            const animation = image.animate([
                { transform: 'translateY(0)' },
                { transform: `translateY(-${overflow}px)` },
            ], {
                duration: Math.max(8000, Math.min(24000, overflow * 18)),
                direction: 'alternate',
                easing: 'ease-in-out',
                iterations: Infinity,
            });

            projectAnimations.set(image, animation);
            animation.pause();
            animation.currentTime = 0;
            if (frame.matches(':hover') || frame.contains(document.activeElement)) animation.play();
        }

        const projectImages = [...document.querySelectorAll('.project-image img')];
        projectImages.forEach(image => {
            bindProjectImageHover(image);
            if (image.complete) animateProjectImage(image);
            else image.addEventListener('load', () => animateProjectImage(image), { once: true });
        });

        let projectResizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(projectResizeTimer);
            projectResizeTimer = setTimeout(() => projectImages.forEach(animateProjectImage), 180);
        });

        const observer = new IntersectionObserver(entries => entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        }), { threshold: .12 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>
