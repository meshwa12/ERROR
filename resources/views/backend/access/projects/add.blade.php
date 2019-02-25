@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.projects.management') . ' | ' . trans('labels.backend.access.projects.add'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.projects.management') }}
        <small>{{ trans('labels.backend.access.projects.add') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.access.project.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post','enctype'=>'multipart/form-data']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.access.projects.add') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.access.includes.partials.project-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                {{-- Project Name --}}
                <div class="form-group">
                    {{ Form::label('Project Name', trans('validation.attributes.backend.access.projects.projectname'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::text('project_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.projects.projectname'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                {{-- Description--}}
                <div class="form-group">
                    {{ Form::label('Description', trans('validation.attributes.backend.access.projects.description'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::text('project_details', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.projects.description'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                {{-- File --}}
                <div class="form-group">
                    {{ Form::label('file', trans('validation.attributes.backend.access.projects.file'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::file('file', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.projects.file'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                
              
                
                {{-- Buttons --}}
                <div class="edit-form-btn">
                    {{ link_to_route('admin.access.project.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.add'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection

@section('after-scripts')
   
    <script type="text/javascript">


        Backend.Utils.documentReady(function(){
            Backend.Projects.selectors.getPremissionURL = "{{ route('admin.get.permission') }}";
            Backend.Projects.init("add");
        });

        window.onload = function () {
            Backend.Projects.windowloadhandler();
        };
        
    </script>
@endsection
