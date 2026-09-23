@extends('layouts.admin')
@section('heading', 'Tổng quan')
@section('content')
<div class="welcome-panel"><div><span>Xin chào, {{ auth()->user()->name }} 👋</span><h2>Portfolio của bạn đang<br><em>sẵn sàng tỏa sáng.</em></h2><p>Cập nhật nội dung thường xuyên để câu chuyện của bạn luôn mới mẻ.</p></div><a href="{{ route('home') }}" target="_blank">Xem website ↗</a></div>
<div class="stats-grid">
    <div class="stat-card"><span>Tổng dự án</span><strong>{{ $projectCount }}</strong><small>Tất cả dự án đã tạo</small></div>
    <div class="stat-card"><span>Đang hiển thị</span><strong>{{ $visibleProjectCount }}</strong><small>Xuất hiện trên trang chủ</small></div>
    <div class="stat-card"><span>Hồ sơ</span><strong>{{ $profile ? '100%' : '0%' }}</strong><small>{{ $profile ? 'Thông tin đã sẵn sàng' : 'Cần cập nhật thông tin' }}</small></div>
</div>
<section class="admin-card"><div class="card-heading"><div><span>NỘI DUNG GẦN ĐÂY</span><h2>Dự án mới cập nhật</h2></div><a href="{{ route('admin.projects.index') }}">Xem tất cả →</a></div>
    @if($latestProjects->isEmpty())<div class="admin-empty">Chưa có dự án nào. <a href="{{ route('admin.projects.create') }}">Tạo dự án đầu tiên</a></div>@else
    <div class="project-list">@foreach($latestProjects as $project)<div class="project-row"><div class="thumb">@if($project->image)<img src="{{ Storage::url($project->image) }}" alt="">@else<span>{{ mb_substr($project->name, 0, 1) }}</span>@endif</div><div class="grow"><strong>{{ $project->name }}</strong><small>Cập nhật {{ $project->updated_at->diffForHumans() }}</small></div><span class="badge {{ $project->is_visible ? 'green' : '' }}">{{ $project->is_visible ? 'Đang hiển thị' : 'Đã ẩn' }}</span><a class="icon-button" href="{{ route('admin.projects.edit', $project) }}">✎</a></div>@endforeach</div>@endif
</section>
@endsection
