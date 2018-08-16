@extends('admin/public/layout')

@section('title')Banner管理@endsection

@section('content')
    <section class="content-header">
        <h1>Banner管理</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <form role="form" name="item_form" id="item_form" method="post">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.banner.create') }}" class="btn btn-default btn-sm"
                                           data-toggle="tooltip" title="添加分类"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-body  no-padding">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th><input type="checkbox" class="checkbox-toggle"/></th>
                                        <th>排序</th>
                                        <th>名称</th>
                                        <th>创建时间</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                    @foreach($banners as $banner)
                                        <tr>
                                            <td><input type="checkbox" value="{{ $banner->id }}" name="ids[]"/></td>
                                            <td>{{ $banner->sort }}</td>
                                            <td>{{ $banner->banner_name }}</td>
                                            <td>{{ $banner->created_at }}</td>
                                            <td>
                                                <span class="label @if($banner->status==1) label-success  @else label-danger @endif">{{ trans_common_status($banner->status) }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group-xs">
                                                    <a class="btn btn-primary"
                                                       href="{{ route('admin.banner.edit',['id'=>$banner->id]) }}"
                                                       data-toggle="tooltip" title="编辑banner信息"><i class="fa fa-edit"
                                                                                                   aria-hidden="true"></i>
                                                        编辑</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            {!! str_replace('/?', '?', $banners->render()) !!}
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