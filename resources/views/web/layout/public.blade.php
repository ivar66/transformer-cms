<!DOCTYPE html>
<html>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?f8eb523b83192dabb564850181190031";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('seo_title','喝醉的清茶')</title>
    <meta name="keywords" content="@yield('seo_keyword','喝醉的清茶')" />
    <meta name="description" content="@yield('seo_description','这是个有趣的博客网站')" />
    <meta name="author" content="drunkTea" />
    <meta name="copyright" content="lovecathy.cn" />
    <link rel="shortcut icon" href="/favicon2.ico" type="image/x-icon" />
<!-- Bootstrap -->
    <link href="{{ asset('/static/css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/static/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/web/global.css')}}" rel="stylesheet" />
@yield('css')
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="top-common-nav  mb-50">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#global-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="logo"><a class="navbar-brand logo" href="{{ route('web.blog.index') }}"><strong>喝醉的清茶</strong></a></div>
            </div>

            <div class="collapse navbar-collapse" style="width: 870px;" id="global-navbar">

                <ul class="nav navbar-nav">
                    <li @if(request()->route()->getName() == 'web.blog.index') class="active" @endif><a href="{{ route('web.blog.index') }}">文章</a></li>
                    <li @if(request()->route()->getName() == 'web.topic.index') class="active" @endif><a href="{{ route('web.topic.index') }}">话题</a></li>
                    <li @if(request()->route()->getName() == 'web.member.index') class="active" @endif><a href="{{ route('web.member.index') }}">关于我</a></li>
                </ul>
                <form class="navbar-form hidden-sm hidden-xs pull-right" role="search" id="top-search-form" action="#" method="GET">
                    <div class="input-group">
                        <input type="text" name="word" id="searchBox" class="form-control" placeholder="" />
                        <span class="input-group-addon btn" ><span id="search-button" class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</div>
<div class="top-alert mt-60 clearfix text-center">
    <!--[if lt IE 9]>
    <div class="alert alert-danger topframe" role="alert">你的浏览器实在<strong>太太太太太太旧了</strong>，放学别走，升级完浏览器再说
        <a target="_blank" class="alert-link" href="http://browsehappy.com">立即升级</a>
    </div>
    <![endif]-->

</div>

<div class="wrap">
    @yield('jumbotron')
    @yield('container')
    <div class="container">
        @yield('content')
    </div>
</div>



<footer id="footer">
    <div class="container">
        @if(isset($friendshipLinks))
        @if(request()->route()->getName() == 'web.blog.index')
            <ul class="list-unstyled list-inline">
                <li>友情链接</li>
                @foreach($friendshipLinks as $link)
                    <li><a target="_blank" href="{{ $link->url }}" title="{{ $link->slogan }}">{{ $link->name }}</a></li>
                @endforeach
            </ul>
        @endif
        @endif
        <div class="text-center">
            <a href="{{ route('web.blog.index') }}">小白白的个人空间</a><span class="span-line">|</span>
            <a href="mailto:625079860@qq.com" target="_blank">联系我们</a><span class="span-line">|</span>
            <a href="http://www.beian.miit.gov.cn/" target="_blank">京ICP备18028786</a>
        </div>
        <div class="copyright mt-10">
            Powered By <a href="http://www.lovecathy.cn" target="_blank"></a> ©2017-{{ gmdate('Y') }} lovecathy.cn
        </div>
    </div>
</footer>




<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('/static/js/jquery.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('/static/css/bootstrap/js/bootstrap.min.js') }}"></script>

@yield('js')
</body>
</html>