var appShow = angular.module( 'knowShow', [], [ '$httpProvider', function ( $httpProvider ) {
    $httpProvider.defaults.headers.post[ 'X-CSRF-TOKEN' ] = $( 'meta[name=csrf-token]' ).attr( 'content' );
} ] );

appShow.controller( 'ShowController', [ '$scope', '$http', function ( $scope, $http ) {
    $scope.blockType = [];
    $scope.blockCategory = [];
    $scope.blocks = [];

    // Добавление нового поля
    $scope.store = function ( value, value2, operation ) {
        switch ( operation ) {
            case "add":
                var body = { 'type_id': value, 'template_id': value2, 'operation': operation };
                $http.post( '/block', body ).then( function success( resp ) {
                    $scope.blocks.push( resp.data );
                    console.log( "added" );
                } );
                break;
            case "save":
                var body = { 'blocks': value, 'operation': operation };
                $http.post( '/block', body ).then( function success( resp ) {
                    $scope.blocks = resp.data;
                    alert( "Сохранено" );
                    console.log( "saved" );
                } );
                break;
            case "delete":
                var body = { 'id': value, 'operation': operation };
                var deleting = confirm( "Удалить?" );
                if ( deleting ) {
                    $http.post( '/block/' + value, { _method: 'delete' } ).then( function success( resp ) {
//                        $scope.blocks = resp.data;
                        console.log( "deleted" );
                        location.reload();
                    } );
                }
                break;
        }
    };

    // Загрузить все типы для combobox
    $scope.loadVaribles = function ( id ) {
        $http.get( '/block_type' ).then( function success( resp ) {
            $scope.blockType = resp.data;
        } );
        $http.get( '/block_category' ).then( function success( resp ) {
            $scope.blockCategory = resp.data;
        } );
        $http.get( '/block/' + id + '/edit' ).then( function success( resp ) {
            $scope.blocks = resp.data;
        } );
    };
    //$scope.loadVaribles();
} ] );

appShow.directive( 'contenteditable', function () {
    return {
        require: 'ngModel',
        link: function ( scope, elm, attrs, ctrl ) {
            elm.on( 'input', function () {
                ctrl.$setViewValue( elm.html() );
            } );

            ctrl.$render = function () {
                elm.html( ctrl.$viewValue );
            };
        }
    };
} );

appShow.directive( 'castToInteger', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function ( scope, element, attrs, ngModel ) {
            ngModel.$parsers.unshift( function ( value ) {
                return parseInt( value, 10 );
            } );
        }
    };
} );

appShow.directive( 'myH1', function () {
    return {
        restrict: 'E',
        scope: { sort: "=", value1: "=" },
        templateUrl: function ( elem, attr ) {
            return '/components/public/' + attr.typer + '.html';
        },
    };
} );
