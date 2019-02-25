<!--Action Button-->
    @if(Active::checkUriPattern('admin/access/prpject') || Active::checkUriPattern('admin/access/project/deleted') || Active::checkUriPattern('admin/access/project/deactivated'))
        @include('backend.access.includes.partials.header-export')
    @endif
<!--Action Button-->
<div class="btn-group">
  <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown">@lang('menus.backend.access.projects.action')
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="{{route('admin.access.project.index')}}"><i class="fa fa-list-ul"></i> @lang('menus.backend.access.projects.list')</a></li>
    @permission('create-project')
    <li><a href="{{route('admin.access.project.create')}}"><i class="fa fa-plus"></i> @lang('menus.backend.access.projects.add-new')</a></li>
    @endauth
    
    @permission('view-deleted-project')
    <li><a href="{{route('admin.access.project.deleted')}}"><i class="fa fa-trash"></i> @lang('menus.backend.access.projects.deleted-projects')</a></li>
    @endauth
    {{-- @permission('view-downloaded-project')
    <li><a href="{{route('admin.access.project.downloaded')}}"><i class="fa fa-download"></i> @lang('menus.backend.access.projects.downloaded-projects')</a></li>
    @endauth--}}
  </ul>
</div>