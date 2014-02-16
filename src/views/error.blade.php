<!DOCTYPE html>
<html>

    <head>
        <title>Заголовок</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        
        
        <style>
            body {
              padding-top: 20px;
              padding-bottom: 20px;
            }

        </style>

    </head>

    <body>

        <div class="container">
            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Ошибка</h3>
                </div>
                  <div class="panel-body">
                      
                      @if($message)
                          <div class="alert alert-danger">
                              {{$message}}<br/>
                              <a href="/">Перейти на главную страницу</a>
                          </div>
                      @endif

                  </div>
              </div>
            </div>
          </div>
        </div>



    </body>

</html>

