/*global
    angular
 */
angular.module('starter').factory('Faq', function ($pwaRequest) {
    var factory = {
        value_id: null
    };

    /**
     * @param valueId
     */
    factory.setValueId = function (valueId) {
        factory.value_id = valueId;
    };

    /**
     * Alias for embedPayload with fallback
     */
    factory.findAll = function () {
        var payload = $pwaRequest.getPayloadForValueId(factory.value_id);
        if (payload !== false) {
            return $pwaRequest.resolve(payload);
        }

        // Otherwise fallback on PWA!
        return $pwaRequest.get('faq/mobile_list/find', {
            urlParams: {
                value_id: this.value_id
            }
        });
    };

    /**
     *
     * @param data
     */
    factory.submit = function (data) {
        return $pwaRequest.post('faq/mobile_list/submit', {
            urlParams: {
                value_id: factory.value_id
            },
            data: data,
            cache: false
        });
    };

    return factory;
});
