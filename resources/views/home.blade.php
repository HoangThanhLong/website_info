@extends('layouts.app')

@section('content')
<header class="site-header">
    <a class="brand" href="#top"><span>HL</span> {{ $profile?->full_name ?? 'Portfolio' }}</a>
    <button class="menu-button" data-menu aria-label="Mở menu">☰</button>
    <nav data-nav>
        <a href="#about">Giới thiệu</a>
        <a href="#projects">Dự án</a>
        <a href="#contact">Liên hệ</a>
        @auth<a class="nav-admin" href="{{ route('admin.dashboard') }}">Quản trị</a>@else<a class="nav-login" href="{{ route('login') }}">Đăng nhập</a>@endauth
    </nav>
</header>

<main id="top">
    <section class="hero">
        <div class="hero-orb orb-one"></div><div class="hero-orb orb-two"></div>
        <div class="hero-copy reveal">
            <div class="eyebrow"><span></span> Xin chào, tôi là</div>
            <h1>{{ $profile?->full_name ?? 'Tên của bạn' }}</h1>
            <h2>{{ $profile?->headline ?? 'Developer & Creative Thinker' }}</h2>
            <p>{{ $profile?->bio ?? 'Hãy cập nhật phần giới thiệu của bạn trong trang quản trị.' }}</p>
            <div class="hero-actions">
                <a class="button primary" href="#projects">Xem dự án <span>↗</span></a>
                <a class="button ghost" href="#contact">Liên hệ với tôi</a>
            </div>
            <div class="social-row">
                @if($profile?->github_url)<a href="{{ $profile->github_url }}" target="_blank" rel="noopener">GitHub ↗</a>@endif
                @if($profile?->facebook_url)<a href="{{ $profile->facebook_url }}" target="_blank" rel="noopener">Facebook ↗</a>@endif
            </div>
        </div>
        <div class="portrait-wrap reveal">
            <div class="portrait-backdrop"></div>
            @if($profile?->avatar)
                <img class="portrait" src="{{ Storage::url($profile->avatar) }}" alt="Ảnh của {{ $profile->full_name }}">
            @else
                <div class="portrait portrait-placeholder"><span>{{ mb_substr($profile?->full_name ?? 'H', 0, 1) }}</span></div>
            @endif
            <div class="floating-card"><span class="status-dot"></span><div><small>Trạng thái</small><strong>Sẵn sàng hợp tác</strong></div></div>
        </div>
    </section>

    <section class="about section" id="about">
        <div class="section-heading reveal"><span>01 / VỀ TÔI</span><h2>Một chút về bản thân</h2></div>
        <div class="about-grid">
            <div class="about-story reveal">
                <p class="lead">Tôi tin rằng một sản phẩm tốt bắt đầu từ sự thấu hiểu và được hoàn thiện bởi sự tỉ mỉ.</p>
                <p>{{ $profile?->bio }}</p>
            </div>
            <div class="facts reveal">
                <div><span>Tuổi</span><strong>{{ $profile?->birth_date ? (int) $profile->birth_date->diffInYears(now()) : '—' }}</strong></div>
                <div><span>Giới tính</span><strong>{{ $profile?->gender ?: '—' }}</strong></div>
                <div><span>Địa điểm</span><strong>{{ $profile?->location ?: '—' }}</strong></div>
                <div><span>Dự án</span><strong>{{ $projects->count() }}+</strong></div>
            </div>
        </div>
        @if($profile?->interests)
        <div class="interests reveal"><span>SỞ THÍCH</span><div>@foreach($profile->interests as $interest)<span class="chip">{{ $interest }}</span>@endforeach</div></div>
        @endif
    </section>

    <section class="projects section" id="projects">
        <div class="section-heading reveal"><span>02 / DỰ ÁN</span><h2>Những sản phẩm<br>tôi đã thực hiện</h2><p>Mỗi dự án là một câu chuyện về vấn đề, giải pháp và những điều tôi học được.</p></div>
        <div class="project-grid">
            @forelse($projects as $project)
            <article class="project-card reveal">
                <div class="project-image">
                    @if($project->image)<img src="{{ Storage::url($project->image) }}" alt="{{ $project->name }}">@else<div class="project-placeholder"><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></div>@endif
                    @if($project->url)<a class="project-link" href="{{ $project->url }}" target="_blank" rel="noopener" aria-label="Mở dự án">↗</a>@endif
                </div>
                <div class="project-meta"><time>{{ $project->completed_at?->translatedFormat('m / Y') ?? 'Đang phát triển' }}</time></div>
                <h3>{{ $project->name }}</h3><p>{{ $project->description }}</p>
            </article>
            @empty
            <div class="empty-state">Các dự án mới đang được chuẩn bị. Hãy quay lại sớm nhé!</div>
            @endforelse
        </div>
    </section>

    <section class="contact section reveal" id="contact">
        <span>03 / LIÊN HỆ</span><h2>Bạn có một ý tưởng?<br><em>Hãy cùng hiện thực hóa.</em></h2>
        @if($profile?->email)<a class="contact-mail" href="mailto:{{ $profile->email }}">{{ $profile->email }} <b>↗</b></a>@endif
        <div class="contact-details"><span>{{ $profile?->phone }}</span><span>{{ $profile?->location }}</span></div>
    </section>
</main>

<footer><a class="brand" href="#top"><span>HL</span></a><p>© {{ date('Y') }} {{ $profile?->full_name }}. Made with care.</p><a href="#top">Lên đầu trang ↑</a></footer>
@endsection
