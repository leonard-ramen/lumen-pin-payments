// Angular App
var app = angular.module('app-pin-payments', ['ngRoute']);

// Angular Routes
app.config([
  '$routeProvider',

  function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'dashboard.html'
      })
      .when('/charges', {
        templateUrl: 'chargesGET.html',
        controller: 'chargesGETCtrl'
      })
      .when('/charges/get', {
        templateUrl: 'chargesGET.html',
        controller: 'chargesGETCtrl'
      })
      .when('/charges/post', {
        templateUrl: 'chargesPOST.html',
        controller: 'chargesPOSTCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  }
]);

/* CONTROLLERS */

// Main Controller
app.controller('mainCtrl', function($scope) {
  
  // Variables
  $scope.charges = {};
  $scope.charges.list = [];

  // Functions
  $scope.toggleButton = function(button) {
    if($(button).hasClass('disabled')) {
      $(button).removeClass('disabled loading');
    }
    else {
      $(button).addClass('disabled loading');
    }
  }
});

// Charges GET Controller
app.controller('chargesGETCtrl', function($scope, $http, $timeout) {

  // Debounced functions
  $scope.deb_get_charges = _.debounce(
    function(button) {
      // Toggle button state
      $scope.toggleButton(button);

      $http
        .get('charges')
        .then(
          function(response) {
            console.log('SUCCESS', response);

            var data = response.data.response;

            $timeout((function() {
              $scope.charges.list = [];

              _.each(data, function(value, key) {
                var obj = {
                  amount: _.ceil(value.amount / 100, 2).toFixed(2),
                  currency: value.currency,
                  description: value.description,
                  name: value.card.name
                };
                $scope.charges.list.push(obj);
              });
            }), 0);

            // Toggle button state
            $scope.toggleButton(button);
          },
          function(response) {
            console.log('FAILURE', response);

            // Toggle button state
            $scope.toggleButton(button);
          }
        );
    },
    500,
    {
      leading: true,
      trailing: false
    }
  );

  $scope.get_charges = function($event) {
    $scope.deb_get_charges($event.target);
  }
});

// Charges POST Controller
app.controller('chargesPOSTCtrl', function($scope, $http) {

  // Variables
  $scope.charges.form = {
    email: 'leonard.laput@ramenmedia.com.au',
    description: 'Donor Test',
    amount: 100,
    ip_address: '1.2.3.4',
    currency: 'AUD',
    card_number: '5520000000000000',
    card_expiry_month: '05',
    card_expiry_year: '2017',
    card_cvc: '123',
    card_firstname: 'Leonard',
    card_lastname: 'Laput',
    card_address_line1: '42 Sevenoaks St',
    card_address_city: 'Lathlain',
    card_address_postcode: '6454',
    card_address_state: 'WA',
    card_address_country: 'Australia'
  };

  // Debounced functions
  $scope.deb_submit_charge = _.debounce(
    function(button) {
      // Toggle button state
      $scope.toggleButton(button);

      $http
        .post(
          'charges',
          {
            email: $scope.charges.form.email,
            description: $scope.charges.form.description,
            amount: $scope.charges.form.amount.toFixed(2).toString(),
            ip_address: $scope.charges.form.ip_address,
            currency: $scope.charges.form.currency,
            card: {
              number: $scope.charges.form.card_number,
              expiry_month: $scope.charges.form.card_expiry_month,
              expiry_year: $scope.charges.form.card_expiry_year,
              cvc: $scope.charges.form.card_cvc,
              firstname: $scope.charges.form.card_firstname,
              lastname: $scope.charges.form.card_lastname,
              address_line1: $scope.charges.form.card_address_line1,
              address_city: $scope.charges.form.card_address_city,
              address_postcode: $scope.charges.form.card_address_postcode,
              address_state: $scope.charges.form.card_address_state,
              address_country: $scope.charges.form.card_address_country
            }
          }
        )
        .then(
          function(response) {
            console.log('SUCCESS', response);

            // Toggle button state
            $scope.toggleButton(button);
          },
          function(response) {
            console.log('FAILURE', response);

            // Toggle button state
            $scope.toggleButton(button);
          }
        );
    },
    500,
    {
      leading: true,
      trailing: false
    }
  );

  $scope.submit_charge = function($event) {
    $scope.deb_submit_charge($event.target);
  };
});

/* SEMANTIC UI */
$('.ui.dropdown').dropdown(); // Initialize Dropdowns