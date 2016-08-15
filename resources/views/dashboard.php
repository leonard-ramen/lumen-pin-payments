<html ng-app="app-pin-payments">
  <head>
    <title>Lumen Pin Payments</title>
    <link rel="stylesheet" href="bower_components/semantic/dist/semantic.min.css">
  </head>
  <body ng-controller="mainCtrl" ng-cloak>
    <div class="pusher">

      <!-- MENU -->
      <div class="ui stackable menu">
        <div class="ui container">
          <a class="header item" class="item" href="#/">
            <i class="home icon"></i> Lumen Pin Payments Test
          </a>
          <div class="ui dropdown item">
            Charges
            <i class="dropdown icon"></i>
            <div class="menu">
              <a class="item" href="#/charges/get">GET /charges</a>
              <a class="item" href="#/charges/post">POST /charges</a>
            </div>
          </div>
        </div>
      </div>
      <!-- /MENU -->

      <!-- CONTENT -->
      <div class="ui container">
        <div ng-view autoscroll="true"></div>
      </div>
      <!-- /CONTENT -->

      <!-- Dashboard -->
      <script type="text/ng-template" id="dashboard.html">
        <h1>Dashboard</h1>
      </script>
      <!-- /Dashboard -->

      <!-- Charges GET-->
      <script type="text/ng-template" id="chargesGET.html">
        <h1>GET /charges</h1>
        <button class="ui green button" ng-click="get_charges($event)">Load Charges</button>
        <table class="ui celled table">
          <thead>
            <tr>
              <th class="two wide">Amount</th>
              <th class="eight wide">Description</th>
              <th class="six wide">Cardholder</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="charge in charges.list track by $index">
              <td>{{charge.amount}} {{charge.currency}}</td>
              <td>{{charge.description}}</td>
              <td>{{charge.name}}</td>
            </tr>
          </tbody>
        </table>
      </script>
      <!-- /Charges GET -->

      <!-- Charges POST-->
      <script type="text/ng-template" id="chargesPOST.html">
        <h1>POST /charges</h1>
        <div class="ui two column stackable grid container">
          <div class="column">
            <div class="ui segment">
              <h2 class="ui header">Form</h2>
              <form class="ui form">
                <h4 class="ui dividing header">Personal Details</h4>
                <div class="field">
                  <label>Email Address</label>
                  <input type="email" ng-model="charges.form.email" placeholder="Email Address">
                </div>
                <div class="field">
                  <label>Description</label>
                  <input type="text" ng-model="charges.form.description" placeholder="Description">
                </div>
                <div class="two fields">
                  <div class="field">
                    <label>Amount</label>
                    <input type="number" ng-model="charges.form.amount" placeholder="Amount">
                  </div>
                  <div class="field">
                    <label>Currency</label>
                    <input type="text" ng-model="charges.form.currency" placeholder="Currency">
                  </div>
                </div>
                <h4 class="ui dividing header">Card Details</h4>
                <div class="field">
                  <label>Card Number</label>
                  <input type="text" ng-model="charges.form.card_number" placeholder="Card Number">
                </div>
                <div class="three fields">
                  <div class="field">
                    <label>Expiry Month</label>
                    <input type="text" ng-model="charges.form.card_expiry_month" placeholder="Expiry Month">
                  </div>
                  <div class="field">
                    <label>Expiry Year</label>
                    <input type="text" ng-model="charges.form.card_expiry_year" placeholder="Expiry Year">
                  </div>
                  <div class="field">
                    <label>CVC</label>
                    <input type="text" ng-model="charges.form.card_cvc" placeholder="CVC">
                  </div>
                </div>
                <div class="two fields">
                  <div class="field">
                    <label>First Name</label>
                    <input type="text" ng-model="charges.form.card_firstname" placeholder="First Name">
                  </div>
                  <div class="field">
                    <label>Last Name</label>
                    <input type="text" ng-model="charges.form.card_lastname" placeholder="Last Name">
                  </div>
                </div>
                <div class="field">
                  <label>Address Line 1</label>
                  <input type="text" ng-model="charges.form.card_address_line1" placeholder="Address Line 1">
                </div>
                <div class="two fields">
                  <div class="field">
                    <label>City</label>
                    <input type="text" ng-model="charges.form.card_address_city" placeholder="City">
                  </div>
                  <div class="field">
                    <label>Postcode</label>
                    <input type="text" ng-model="charges.form.card_address_postcode" placeholder="Postcode">
                  </div>
                </div>
                <div class="two fields">
                  <div class="field">
                    <label>State</label>
                    <input type="text" ng-model="charges.form.card_address_state" placeholder="State">
                  </div>
                  <div class="field">
                    <label>Country</label>
                    <input type="text" ng-model="charges.form.card_address_country" placeholder="Country">
                  </div>
                </div>
                <div class="ui green button" tabindex="0" ng-click="submit_charge($event)">Charge</div>
              </form>
            </div>
          </div>
          <div class="column">
            <div class="ui segment">
              <h2 class="ui header">Result</h2>
            </div>
          </div>
        </div>
      </script>
      <!-- /Charges POST -->
    </div>

    <!-- SCRIPTS -->
    <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="bower_components/semantic/dist/semantic.min.js"></script>
    <script type="text/javascript" src="bower_components/angular/angular.min.js"></script>
    <script type="text/javascript" src="bower_components/angular-route/angular-route.min.js"></script>
    <script type="text/javascript" src="bower_components/lodash/dist/lodash.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <!-- /SCRIPTS -->
  </body>
</html>