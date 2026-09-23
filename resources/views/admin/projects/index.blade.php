@extends('layouts.admin')
@section('title', 'Quản lý dự án')
@section('heading', 'Quản lý dự án')
@section('content')
<section class="admin-card"><div class="card-heading"><div><span>PROJECTS</span><h2>Tất cả dự án</h2></div><strong>{{ $projects->total() }} dự án</strong></div>
@if($projects->isEmpty())<div class="admin-empty">Chưa có dự án nào. <a href="{{ route('admin.projects.create') }}">Thêm ngay</a></div>@else
<div class="admin-table"><table><thead><tr><th>Dự án</th><th>Hoàn thiện</th><th>Thứ tự</th><th>Trạng thái</th><th></th></tr></thead><tbody>@foreach($projects as $project)<tr><td><div class="project-cell"><div class="thumb">@if($project->image)<img src="{{ Storage::url($project->image) }}" alt="">@else<span>{{ mb_substr($project->name,0,1) }}</span>@endif</div><div><strong>{{ $project->name }}</strong><small>{{ Str::limit($project->description, 60) }}</small></div></div></td><td>{{ $project->completed_at?->format('d/m/Y') ?? '—' }}</td><td>{{ $project->sort_order }}</td><td><span class="badge {{ $project->is_visible ? 'green' : '' }}">{{ $project->is_visible ? 'Hiển thị' : 'Đã ẩn' }}</span></td><td><div class="row-actions"><a href="{{ route('admin.projects.edit', $project) }}">Sửa</a><form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Bạn chắc chắn muốn xóa dự án này?')">@csrf @method('DELETE')<button>Xóa</button></form></div></td></tr>@endforeach</tbody></table></div>{{ $projects->links() }}@endif
</section>
@endsection
