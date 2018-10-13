@extends('web.layout.public')
@section('seo_title'){{ $seoTDK['seo_title'] }}@endsection
@section('seo_keyword'){{$seoTDK['seo_keyword'] }}@endsection
@section('seo_description'){{ $seoTDK['seo_description'] }}@endsection
@section('content')
    <div class="row mt-10">
        <div class="col-xs-12 col-md-9 main">
            @if(isset($categories) and $categories )
                <div class="widget-category clearfix mb-10">
                        <ul class="nav nav-tabs mb-10">
                            <li @if( 0 == $currentCategoryId ) class="active" @endif ><a href="{{ route('web.blog.index') }}">全部</a></li>
                            @foreach( $categories as $category )
                                <li @if( $category->id == $currentCategoryId ) class="active" @endif ><a href="{{ route('web.blog.index',['category_slug'=>$category->slug]) }}">{{ $category->category_name }}</a></li>
                            @endforeach
                        </ul>
                </div>
            @endif


            @if(isset($articles))
            <div class="stream-list blog-stream">
                    @foreach($articles as $article)
                        <section class="stream-list-item clearfix">
                            @if( $article->logo )
                                <div class="blog-rank hidden-xs">
                                    <a href="{{ route('web.blog.detail',['id'=>$article->id]) }}" target="_blank"><img style="width: 200px;height:120px;" src="{{ route('website.image.show',['image_name'=>$article->logo]) }}"></a>
                                </div>
                            @endif
                            <div class="summary">
                                <h2 class="title"><a href="{{ route('web.blog.detail',['id'=>$article->id]) }}" target="_blank" >{{ $article->title }}</a></h2>
                                <p class="excerpt wordbreak">{{ $article->summary }}</p>
                                <ul class="author list-inline mt-20">
                                    <li class="pull-right" title="{{ $article->collections }} 收藏">
                                        <span class="glyphicon glyphicon-bookmark"></span> {{ $article->collections }}
                                    </li>
                                    <li class="pull-right" title="{{ $article->collections }} 推荐">
                                        <span class="glyphicon glyphicon-thumbs-up"></span> {{ $article->supports }}
                                    </li>
                                    <li>
                                        <a href="#" target="_blank">
                                            <img class="avatar-20 mr-10 hidden-xs" src="{{ get_user_avatar($article->user_id,'small') }}" alt="{{ $article->user->name }}"> {{ $article->user->name }}
                                        </a>
                                    </li>
                                    <li>发布于 {{ timestamp_format($article->created_at) }}</li>
                                    <li>阅读 ( {{$article->views}} )</li>

                                </ul>
                            </div>
                        </section>
                    @endforeach


            </div>

            <div class="text-center">
                {!! str_replace('/?', '?', $articles->render()) !!}
            </div>
                @endif
        </div><!-- /.main -->
        <div class="col-xs-12 col-md-3 side">
            {{--<div class="side-alert alert alert-warning">--}}
                {{--<p>今天，有什么经验需要分享呢？</p>--}}
                {{--<a href="#" class="btn btn-primary btn-block mt-10">立即撰写</a>--}}
            {{--</div>--}}
            {{--<div class="side-alert alert alert-warning">--}}
                {{--<ul class="panel_head"><span>test-新浪微博</span></ul>--}}
                {{--<ul class="panel_body">--}}
                    {{--<iframe class="side-alert alert alert-warning" id="weibo" style="width:300px; height:300px;" frameborder="0" scrolling="yes" src="http://v.t.sina.com.cn/widget/widget_blog.php?uid=3170527197"></iframe>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection
