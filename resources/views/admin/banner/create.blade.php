@extends('admin/public/layout')

@section('title')Banner管理@endsection

@section('content')
    <section class="content-header">
        <h1>
            Banner管理
            <small>添加Banner</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <form role="form" name="addForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.banner.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group @if($errors->has('banner_name')) has-error @endif">
                                <label for="title">banner标题:</label>
                                <input id="title" type="text" name="banner_name"  class="form-control input-sm" placeholder="banner 名称" value="{{ old('banner_name','') }}" />
                                @if($errors->has('banner_name')) <p class="help-block">{{ $errors->first('banner_name') }}</p> @endif
                            </div>

                            <div class="form-group @if($errors->has('banner_pic_url')) has-error @endif">
                                <label>banner封面</label>
                                <input type="file" name="banner_pic_url"/>
                                @if($errors->has('banner_pic_url')) <p class="help-block">{{ $errors->first('banner_pic_url') }}</p> @else <p class="help-block">建议尺寸800*120</p> @endif
                            </div>

                            <div class="form-group @if($errors->has('banner_url')) has-error @endif">
                                <label for="title">banner跳转url:</label>
                                <input id="title" type="text" name="banner_url"  class="form-control input-sm" placeholder="banner跳转url" value="{{ old('banner_url','') }}" />
                                @if($errors->has('banner_url')) <p class="help-block">{{ $errors->first('banner_url') }}</p> @endif
                            </div>

                            <div class="form-group @if($errors->has('sort')) has-error @endif">
                                <label>排序</label>
                                <input type="text" name="sort" class="form-control " placeholder="排序：默认为0"
                                       value="{{ old('sort','') }}">
                                @if($errors->has('sort')) <p class="help-block">{{ $errors->first('sort') }}</p> @endif
                            </div>

                            <div class="form-group">
                                <label>状态</label>
                                <span class="text-muted">(禁用后前台不会显示)</span>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status" value="1" @if(old('sort','') ==1)checked @endif /> 启用
                                    </label>&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="status" value="2" @if(old('sort','') ==2)checked @endif /> 禁用
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        set_active_menu('manage_content', "{{ route('admin.banner.index') }}");
    </script>
@endsection