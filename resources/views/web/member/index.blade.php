@extends('web.layout.public')
@section('seo_title'){{'喝醉的清茶-关于我'}}@endsection
@section('seo_keyword'){{'喝醉的清茶-关于我'}}@endsection
@section('seo_description'){{'喝醉的清茶-关于我' }}@endsection
@section('content')
    <div class="container" >
        <div class="header" style="display: flex;text-align: center;padding: 50px;">
            <img class="avatar-128" style="margin: 0 auto" src="https://avatar-static.segmentfault.com/977/959/977959162-5a59cf9e1d814_huge256" alt="">
        </div>
        <div class="panel panel-success col-md-offset-3" style="width: 600px;">
            <div class="panel-heading panel-success">
                <h3 class="panel-title">Who am I?</h3>
            </div>
            <div class="panel-body">
                <button class="btn btn-info" type="button">
                    <span class="badge">Age</span>&nbsp;&nbsp;90后
                </button>&nbsp;

                <button class="btn btn-primary" type="button">
                    <span class="badge">毕业院校</span>&nbsp;&nbsp;北京化工大学 计算机专业
                </button>
                </br></br>

                <button class="btn btn-warning" type="button">
                    <span class="badge">联系方式</span>
                    625079860@qq.com
                </button>
                <button class="btn btn-success" type="button">
                    <span class="badge">hobby</span>
                    reading,travel
                </button>

            </div>
        </div>
    </div>
@endsection