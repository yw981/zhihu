@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">控制面板</div>

                <div class="card-body">
                    <p>如果你点我，我就会消失。</p>
                    <p>继续点我!</p>
                    <p>接着点我!</p>
                    test！
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $("p").click(function(){
                $(this).hide();
            });
        });
    </script>
@endsection
