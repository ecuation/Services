
var vue = require('vue');

new Vue({
    el: '#users',

    data:{
        active: true
    },

    filters: {
        revere: require('./filters/reverse')
    }
});

//# sourceMappingURL=app.js.map