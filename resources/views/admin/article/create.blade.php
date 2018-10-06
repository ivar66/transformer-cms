@extends('admin/public/layout')
@section('title')
    添加文章
@endsection

@section('css')
    <link href="{{ asset('/static/js/summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{ asset('/static/js/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/static/js/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet">
@endsection
@section('content')
    <section class="content-header">
        <h1>
            文章管理
            <small>添加文章</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <form role="form" name="addForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.article.store') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group @if($errors->has('title')) has-error @endif">
                                <label for="title">文章标题:</label>
                                <input id="title" type="text" name="title"  class="form-control input-lg" placeholder="这是一个标题" value="{{ old('title','') }}" />
                                @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                            </div>

                            <div class="form-group @if($errors->has('logo')) has-error @endif">
                                <label>文章封面</label>
                                <input type="file" name="logo"/>
                                @if($errors->has('logo')) <p class="help-block">{{ $errors->first('logo') }}</p> @else <p class="help-block">建议尺寸200*120</p> @endif
                            </div>

                            <div class="form-group  @if($errors->has('content')) has-error @endif">
                                <label for="article_editor">文章正文：</label>
                                <div id="article_editor">{!! old('content','') !!}</div>
                                @if($errors->has('content')) <p class="help-block">{{ $errors->first('content') }}</p> @endif
                            </div>

                            <div class="form-group @if($errors->has('summary')) has-error @endif">
                                <label for="editor">文章导读：</label>
                                <textarea name="summary" class="form-control" placeholder="文章摘要">{{ old('summary','') }}</textarea>
                                @if($errors->has('summary')) <p class="help-block">{{ $errors->first('summary') }}</p> @endif
                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="0">请选择分类</option>
                                        @include('admin.category.option',['type'=>'articles','select_id'=>old('category_id',0)])
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>状态</label>
                                <span class="text-muted">(禁用后前台不会显示)</span>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="status" value="1" checked/> 启用
                                    </label>&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="status" value="0"/> 禁用
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <input type="hidden" id="article_editor_content"  name="content" value="{{ old('content','') }}"  />
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
        $(function () {
            set_active_menu('manage_content',"{{ route('admin.article.index') }}");
        });
    </script>
    <script src="{{ asset('/static/js/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('/static/js/summernote/lang/summernote-zh-CN.min.js') }}"></script>
    <script src="{{ asset('/static/js/select2/js/select2.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#article_editor').summernote({
                lang: 'zh-CN',
                height: 350,
                placeholder:'写文章啦～',
                {{--toolbar: [ {!! config('project.summernote.blog') !!} ],--}}
                callbacks: {
                    onChange:function (contents, $editable) {
                        var code = $(this).summernote("code");
                        $("#article_editor_content").val(code);
                    },
                    onImageUpload: function(files) {
                        upload_editor_image(files[0],'article_editor');
                    }
                }
            });

        });
    </script>
@endsection
