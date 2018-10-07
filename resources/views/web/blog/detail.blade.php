@extends('web.layout.public')
@section('seo_title'){{'喝醉的清茶-'.$article->title }}@endsection
@section('seo_keyword'){{'喝醉的清茶-'.$article->title }}@endsection
@section('seo_description'){{'喝醉的清茶-'.$article->summary }}@endsection
@section('css')
    <link href="{{ asset('/static/js/fancybox/jquery.fancybox.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css">
@endsection

@section('content')
    <div class="row mt-10">
        <div class="col-xs-12 col-md-9 main">
            <div class="widget-question widget-article">
                <h3 class="title">{{ $article->title }}</h3>
                @if($article->tags)
                    <ul class="taglist-inline">
                        @foreach($article->tags as $tag)
                            <li class="tagPopup"><a class="tag" href="#">{{ $tag->tag_name }}</a></li>
                        @endforeach
                    </ul>
                @endif
                <div class="content mt-10">
                    <div class="quote mb-20">
                        {{ $article->summary }}
                    </div>
                    <div class="text-fmt">
                        {!! $article->content !!}
                    </div>
                    <div class="post-opt mt-30">
                        <ul class="list-inline text-muted">
                            <li>
                                <i class="fa fa-clock-o"></i>
                                发表于 {{ timestamp_format($article->created_at) }}
                            </li>
                            <li>阅读 ( {{$article->views}} )</li>
                            @if($article->category_id)
                                <li>分类：<a href="{{ route('web.blog.index',['category_slug'=>$article->category->slug]) }}" target="_blank">{{ $article->category->category_name }}</a>
                                </li>
                            @endif
                                {{--@if($article->status !== 2 && Auth()->check() && (Auth()->user()->id === $article->user_id || Auth()->user()->is('admin') ) )--}}
                                    {{--<li><a href="{{ route('blog.article.edit',['id'=>$article->id]) }}" class="edit" data-toggle="tooltip" data-placement="right" title="" data-original-title="进一步完善文章内容"><i class="fa fa-edit"></i> 编辑</a></li>--}}
                                {{--@endif--}}
                        </ul>
                    </div>
                    <div class="mb-10">
                        <div class="social-share share-component" data-mobile-sites="weibo,qq,qzone,tencent,wechat">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/jquery.share.min.js"></script>
    <script>
        $('.social-share').share(
            {
                // title:'',
                wechatQrcodeTitle:'扫描一下，分享给大家哦～',
                wechatQrcodeHelper:"<p>微信扫一下</p><p>可将本文分享至朋友圈。</p>"
                //参考资料
                //https://blog.csdn.net/kingrome2017/article/details/77946766
                //https://www.npmjs.com/package/social-share
            }
        );
    </script>
@endsection