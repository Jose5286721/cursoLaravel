require('./bootstrap');

import Vue from 'vue'
import VueExcelEditor from 'vue-excel-editor'

Vue.use(VueExcelEditor)
var app = new Vue({
    el:'#app',
    data: {
        jsondata: [
            {user: 'hc', name: 'Harry Cole',    phone: '1-415-2345678', gender: 'M', age: 25, birth: '1997-07-01'},
            {user: 'sm', name: 'Simon Minolta', phone: '1-123-7675682', gender: 'M', age: 20, birth: '1999-11-12'},
            {user: 'ra', name: 'Raymond Atom',  phone: '1-456-9981212', gender: 'M', age: 19, birth: '2000-06-11'},
            {user: 'ag', name: 'Mary George',   phone: '1-556-1245684', gender: 'F', age: 22, birth: '2002-08-01'},
            {user: 'kl', name: 'Kenny Linus',   phone: '1-891-2345685', gender: 'M', age: 29, birth: '1990-09-01'}
        ]
    }
})