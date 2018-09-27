@extends('web.layout.public')
@section('content')
    <div class="row mt-10">
        <div class="col-xs-12 col-md-9 main">
            @if(isset($categories) and $categories )
                <div class="widget-category clearfix mb-10">
                    <div class="col-sm-12">
                        <ul class="list">
                            <li><a href="{{ route('website.blog') }}">全部</a></li>
                            @foreach( $categories as $category )
                                <li @if( $category->id == $currentCategoryId ) class="active" @endif ><a href="{{ route('website.blog',['category_slug'=>$category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if(isset($articles))
            <div class="stream-list blog-stream">
                    @foreach($articles as $article)
                        <section class="stream-list-item clearfix">
                            @if( $article->logo )
                                <div class="blog-rank hidden-xs">
                                    <a href="{{ route('blog.article.detail',['id'=>$article->id]) }}" target="_blank"><img style="width: 200px;height:120px;" src="{{ route('website.image.show',['image_name'=>$article->logo]) }}"></a>
                                </div>
                            @endif
                            <div class="summary">
                                <h2 class="title"><a href="{{ route('blog.article.detail',['id'=>$article->id]) }}" target="_blank" >{{ $article->title }}</a></h2>
                                <p class="excerpt wordbreak">{{ $article->summary }}</p>
                                <ul class="author list-inline mt-20">
                                    <li class="pull-right" title="{{ $article->collections }} 收藏">
                                        <span class="glyphicon glyphicon-bookmark"></span> {{ $article->collections }}
                                    </li>
                                    <li class="pull-right" title="{{ $article->collections }} 推荐">
                                        <span class="glyphicon glyphicon-thumbs-up"></span> {{ $article->supports }}
                                    </li>
                                    <li>
                                        <a href="{{ route('auth.space.index',['user_id'=>$article->user_id]) }}" target="_blank">
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
            <div class="side-alert alert alert-warning">
                <p>今天，有什么经验需要分享呢？</p>
                <a href="#" class="btn btn-primary btn-block mt-10">立即撰写</a>
            </div>
            {{--@include('theme::layout.auth_menu')--}}

            <div class="widget-box">
                <h2 class="h4 widget-box__title">推荐文章</h2>
                <ul class="widget-links list-unstyled list-text">
                    @if(isset($hotArticles))
                    @foreach($hotArticles as $hotArticle)
                        <li class="widget-links-item">
                            <a title="{{ $hotArticle->title }}" href="{{ route('blog.article.detail',['id'=>$hotArticle->id]) }}">{{ $hotArticle->title }}</a>
                            <small class="text-muted">{{ $hotArticle->supports }} 推荐</small>
                        </li>
                    @endforeach
                    @endif

                </ul>
            </div>


            <div class="widget-box">
                <h2 class="h4 widget-box-title">热议话题 <a href="#" title="更多">»</a></h2>
                <ul class="taglist-inline multi">
                    @if(isset($hotTags))
                    @foreach($hotTags as $hotTag)
                        {{--<li class="tagPopup"><a class="tag" data-toggle="popover"  href="{{ route('ask.tag.index',['id'=>$hotTag->tag_id,'source_type'=>'articles']) }}">{{ $hotTag->name }}</a></li>--}}
                    @endforeach
                    @endif
                </ul>
            </div>

        </div>
    </div>
@endsection
