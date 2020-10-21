var appIndex = angular.module( 'knowIndex', [], [ '$httpProvider', function ( $httpProvider ) {
    $httpProvider.defaults.headers.post[ 'X-CSRF-TOKEN' ] = $( 'meta[name=csrf-token]' ).attr( 'content' );
} ] );

appIndex.controller( 'IndexController', [ '$scope', '$http', function ( $scope, $http ) {
    $scope.category = [];
    $scope.ckCategory = false;

    // Добавление нового поля
    $scope.store = function ( id, value, operation ) {
        switch ( operation ) {
            case "add":
                var body = { 'id': id, 'name': value, 'operation': operation };
                $http.post( '/template_category', body ).then( function success( resp ) {
                    location.reload();
                    $scope.category.push( resp.data );
                    console.log( "added" );
                } );
                break;
            case "save":
                var body = { 'blocks': value, 'operation': operation };
                $http.post( '/template_category', body ).then( function success( resp ) {
                    $scope.category = resp.data;
                    alert( "Сохранено" );
                    console.log( "saved" );
                    $scope.ckCategory = false;
                } );
                break;
        }
    }

    $scope.checkAdd = function ( val1, val2, val3 ) {
        let x = 0;
        if ( Number( val1 ) > 0 ) x = val1;
        if ( Number( val2 ) > 0 ) x = val2;
        if ( Number( val3 ) > 0 ) x = val3;
        return x;
    };

    $scope.checkAddCat = function ( val1, val2 ) {
        let x = 0;
        if ( Number( val1 ) > 0 ) x = val1;
        if ( Number( val2 ) > 0 ) x = val2;
        return x;
    };

    $scope.toNumVal= function(sel)
    {
        return Number(sel);
    };


    // Добавление нового поля
    $scope.storeTemplate = function ( id, name, operation ) {
        switch ( operation ) {
            case "add":
                var body = { 'id': id, 'name': name, 'operation': operation };
                $http.post( '/templates', body ).then( function success( resp ) {
                    location.reload();
                } );
                break;
            case "delete":
                var body = { 'id': id, 'operation': operation };
                var deleting = confirm( "Удалить?" );
                if ( deleting ) {
                    $http.post( '/templates/' + id, { _method: 'delete' } ).then( function success( resp ) {
                        console.log( "deleted" );
                        location.reload();
                    } );
                }
                break;
        }
    }

    // Загрузить все типы для combobox
    $scope.loadVaribles = function () {
        $http.get( '/template_category' ).then( function success( resp ) {
            console.log(resp.data);
            $scope.category = resp.data;
        } );
    };
} ] );

appIndex.directive( 'contenteditable', function () {
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
