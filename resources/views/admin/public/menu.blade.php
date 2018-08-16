<ul class="sidebar-menu" id="root_menu">
    <li class="header">管理菜单</li>
    <li><a href="{{ route('admin.index.index') }}"><i class="fa fa-dashboard"></i> <span>首页</span> </a></li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-wrench"></i> <span>全局</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu" id="global">
            <li><a href="#"><i class="fa fa-circle-o"></i> 站点设置</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-comments-o"></i> <span>内容</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu" id="manage_content">
            <li><a href="{{ route('admin.article.index') }}"><i class="fa fa-circle-o"></i> 文章管理</a></li>
            <li><a href="{{ route('admin.tag.index') }}"><i class="fa fa-circle-o"></i> 标签管理</a></li>
            <li><a href="{{ route('admin.category.index') }}"><i class="fa fa-circle-o"></i> 分类管理</a></li>
            <li><a href="{{ route('admin.banner.index') }}"><i class="fa fa-circle-o"></i> Banner管理</a></li>
        </ul>
    </li>


    <li class="header">常用菜单</li>
    <li><a href="#" target="_blank"><i class="fa fa-circle-o text-success"></i> <span>网站首页</span></a></li>
</ul>
