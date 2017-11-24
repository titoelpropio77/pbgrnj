<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        {!!Html::style('css/bootstrap.min.css')!!}
        {!!Html::style('css/metisMenu.min.css')!!}
        {!!Html::style('css/sb-admin-2.css')!!}
        {!!Html::style('css/font-awesome.min.css')!!}
        {!!Html::style('css/AdminLTE.min.css')!!}
        {!!Html::style('css/style.css')!!}

        {!!Html::script('js/jquery.min.js')!!}
        {!!Html::script('js/bootstrap.min.js')!!}
        {!!Html::style('css/toastr.css')!!}
        {!!Html::script('js/toastr.min.js')!!}

        {!!Html::style('css/alertify.css')!!}
        {!!Html::style('css/default.css')!!}
        
    </head>

    <body>
        <div id="wrapper">
            <div id="page-wrapper">
                @yield('content')
            </div>
        </div>
        {!!Html::script('js/moment.js')!!}
        {!!Html::script('js/numerosmasdecimal.js')!!}
        {!!Html::script('js/metisMenu.min.js')!!}
        {!!Html::script('js/sb-admin-2.js')!!}
        {!!Html::script('js/alertify.js')!!}
    </body>
</html>
