<!DOCTYPE html>
<html lang="en" ng-app="main">
    <head>
        <title>Search</title>
        <link href="{{ asset('css/app.css')}}" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" ng-controller="SearchController">
                    <div class="page-header">
                        <h1>
                            Search page
                        </h1>
                    </div>
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input
                                        class="form-control"
                                        ng-model="keywords"
                                        name="keywords"
                                        type="text"
                                        placeholder="Enter search string"
                                        autocomplete="off" />
                                </div> 
                                <button type="submit" class="btn btn-default" ng-click="search()">
                                    Search
                                </button>
                            </form>
                        </div>
                    </nav>
                    @include('listgroup')
                </div>
            </div>
        </div>
        <script>
            var config = <?= $config ?>;
        </script>
        <script src="{{ asset('js/app.js')}}"></script>
    </body>
</html>