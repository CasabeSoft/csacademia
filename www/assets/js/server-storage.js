/* global kendo */
define(['jquery'], function ($) {
    var _STORAGE_SERVICE_URL = '/api/config/value';
    
    return {
        getItem: function (key) {
            return $.getJSON(_STORAGE_SERVICE_URL + '/' + key);
        },
        
        setItem: function (key, value) {
            return $.post(_STORAGE_SERVICE_URL, {key: key, value: value});
        },
        
        removeItem: function (key) {
            return $.ajax({
                url: _STORAGE_SERVICE_URL + '/' + key,
                type: 'DELETE'
            });
        }
    };
});