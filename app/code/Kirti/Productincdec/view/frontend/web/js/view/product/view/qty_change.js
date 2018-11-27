define([
  'jquery',
   'ko',
   'uiComponent'
], function ($, ko, Component) {
   'use strict';
   return Component.extend({
       initialize: function () {
           //initialize parent Component
           this._super();
           this.qty = ko.observable(this.defaultQty);
       },
       decreaseQty: function() {
        var currentQty = $('#qty').val();
           var newQty = Number(currentQty) - 1;
           if (newQty < 1) 
           {
               newQty = 1;
           }
           this.qty(newQty);
       },
       increaseQty: function() {
            
            var currentQty = $('#qty').val();
           var newQty = Number(currentQty) + 1;
           this.qty(newQty);
       }
   });
});