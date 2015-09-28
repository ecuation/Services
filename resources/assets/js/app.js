
var Vue = require('vue');

Vue.use(require('vue-resource'));

Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

new Vue({
    el: '#users',

    data:{
        users:[]
    },

    ready: function(){
        this.getUsers();
    },

    filters: {
        revere: require('./filters/reverse')
    },
    methods:
    {
        getUsers: function()
        {
            this.$http.get('/api/users', function(users){
                this.users = users;
            });
        },
        toggleUserState: function(user){
            user.is_active = ! user.is_active;
            this.$http.post('/api/user/'+user.id, user);
        },
        deleteUser: function(user)
        {
            this.users.$remove(user);
        }
    }
});
