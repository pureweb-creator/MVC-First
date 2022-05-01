$(document).ready(function(){
    const SITE_URL = $('body').data('site-url');

    // components
    Vue.component('filter-options', {
        props: {
            name: String,
            id: String,
            options: Array,
            categories: Array
        },
        data() {
            return{
                ordering: "pub_date|asc"
            }
        },
        methods: {
            doFilter: function () {
                axios.get(SITE_URL+'/app/controllers/inc/filter-contr.php?categories=' + this.categories + "&ordering=" + this.ordering)
                    .then(response => {
                        this.$root.products = response.data
                    })
            }
        },
        template: `
        <div class="row">
            <div class="col-12 col-lg-3 col-md-3 col-sm-6 ms-auto mb-3">
                <select @change="doFilter" class="form-select ml-auto d-block mb-3" aria-label="Default select" :name="name" :id="id" v-model="ordering" style="width: 100%">
                    <option v-for="option in options" :value="option.name"> {{option.desc}} </option>
                </select>
            </div>
        </div>
        `
    });

    Vue.component('product-card', {
        props: {
            product: {required: false}
        },
        delimiters: ['[[', ']]'],
        data() {
            return {
                errored: false,
                response: {}
            }
        },
        methods: {
            addToCart: function (id) {
                let url = SITE_URL+"/app/controllers/inc/cart-add-contr.php?pid=" + id
                axios
                    .get(url)
                    .then(response => {
                        this.response = response.data
                        account.getCart()

                        if (!this.response.productAlreadyAdded)
                            $('#exampleModal').modal('show')
                        // console.log(response.data)
                    })
                    .catch(error => {
                        this.errored = true
                        console.log(error)
                    })
            }
        },
        template: `
        <div class="col-lg-3 col-md-6 col-12 mb-4" :pid="[[ product.id ]]">
            <li class="card h-100">
                <div class="card-body">
                    <figure>
                        <img loading="lazy" :src="[[ product.image ]]" :title="[[ product.name ]]" :alt="[[ product.name ]]" class="card-img-top">
                    </figure>
                    <h5 class="card-title">[[ product.name ]]</h5>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary" @click="addToCart(product.id)">
                            Shop now
                        </button>
                        <span class="text-success card-footer__price"><strong>$[[ product.price ]]</strong></span>
                    </div>
                    <p class="text-danger" v-if="errored">Unexpected error</p>
                    <p class="text-danger" v-if="response.productAlreadyAdded == true && product.id == response.current_pid">[[ response.errorsMessage ]]</p>
                </div>
            </li>
        </div>`
    });

    Vue.component('cart-product-card', {
        props: {
            products: {required: false}
        },
        delimiters: ['[[', ']]'],
        methods: {
            removeFromCart: function (id){
                axios.get(SITE_URL+`/app/controllers/inc/cart-remove-contr.php?id=${id}`)
                    .then(response => {
                        // console.log(response.data)
                        account.getCart()
                    })
            },
            clearCart: function (){
                axios.get(SITE_URL+"/app/controllers/inc/cart-clear-contr")
                    .then(response => {
                        this.errors= response.data
                        // console.log(response.data)
                        account.getCart()
                    })
            }

        },
        template: `
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center"><a @click="clearCart" class="btn btn-sm btn-outline-danger" href="#">Clear Cart</a></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products">
                        <td>
                            <div class="product-item">
                                <a class="product-thumb" href="#"><img :src="[[ product.image ]]" alt="Product"></a>
                                <div class="product-info">
                                    <h4 class="product-title">[[ product.name ]]</h4>
                                </div>
                            </div>
                        </td>
                        <td class="text-center text-lg text-medium">$[[ product.price ]]</td>
                        <td class="text-center">
                            <a class="remove-from-cart" @click="removeFromCart(product.id)" href="#" data-toggle="tooltip" title="" data-original-title="Remove item">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        `
    });

    // instances
    if ($('#account').length) {
        let account = new Vue({
            el: "#account",
            delimiters: ['[[', ']]'],
            data() {
                return {
                    categories: [],
                    products: [],
                    cartProducts: [],
                    cartCount: 0,
                    totals: 0,

                    options: [
                        {
                            "name":"price|asc",
                            "desc": "From cheap to expensive"
                        },
                        {
                            "name":"price|desc",
                            "desc": "From expensive to cheap"
                        },
                        {
                            "name":"pub_date|asc",
                            "desc": "From new to old"
                        },
                        {
                            "name":"pub_date|desc",
                            "desc": "From old to new"
                        }
                    ]
                }
            },
            methods: {
                getAllProducts: function () {
                    axios.get(SITE_URL+`/app/controllers/inc/load-contr.php?table=product`)
                        .then(response => {
                            this.products = response.data
                            // console.log(response.data)
                        })
                },
                
                getCart: function () {
                    axios.get(SITE_URL+'/app/controllers/inc/load-cart-contr.php')
                        .then(response => {
                            this.cartProducts = response.data[0] || response.data
                            this.cartCount = response.data[1]
                            this.totals = response.data[2]

                            // console.log(this.cartProducts)
                        })
                },

                doFilter: function () {
                    axios.get(SITE_URL+'/app/controllers/inc/filter-contr.php?categories=' + this.categories + "&ordering=" + this.$refs.filterOrdering.ordering)
                        .then(response => {
                            // console.log(response.data)
                            this.products = response.data
                        })
                    },
                },
            created() {
                this.getAllProducts()
                this.getCart()
            }
        })
    }

    if ($('#loginApp').length) {
        new Vue({
            el: '#loginApp',
            data() {
                return {
                    login: "",
                    password: "",
                    errors: {},
                    pwdHidden: true
                }
            },
            delimiters: ['[[', ']]'],
            methods: {
                doLogin: function () {
                    let formData = new FormData();
                    formData.append('login', this.login)
                    formData.append('password', this.password)

                    axios({
                        method: "post",
                        url: SITE_URL+"/app/controllers/inc/login-contr.php",
                        data: formData
                    })
                        .then(response => {
                            this.errors = response.data
                            // console.log(this.errors)

                            if (response.data.length == 0)
                                window.location.href = "/phptutor/mvcproj/"
                        })
                }
            }
        });
    }

    if ($('#signUpApp').length) {
        new Vue({
            el: '#signUpApp',
            data() {
                return {
                    login: "",
                    email: "",
                    password: "",
                    passwordRepeat: "",
                    errors: {},
                    success: false,
                    pwdHidden: false
                }
            },
            delimiters: ['[[', ']]'],
            methods: {
                signUp: function () {
                    let formData = new FormData()
                    formData.append('login', this.login)
                    formData.append('password', this.password)
                    formData.append('passwordRepeat', this.passwordRepeat)
                    formData.append('email', this.email)

                    axios({
                        method: "post",
                        url: SITE_URL+"/app/controllers/inc/signup-contr.php",
                        data: formData,
                    })
                        .then(response => {
                            this.errors = response.data
                            console.log(this.errors)
                            // console.log(Object.keys(response.data), Object.values(response.data))

                            if (response.data.length == 0) {
                                this.success = true;
                                window.location.href = "/phptutor/mvcproj/"
                            }
                        })
                        .catch(response => {
                            console.log(response.data)
                        })
                }
            }
        });
    }

    if ($('#resetPassword').length) {
        new Vue({
            el: '#resetPassword',
            data() {
                return {
                    email: "",
                    errors: {}
                }
            },
            delimiters: ['[[', ']]'],
            methods: {
                doReset: function () {
                    let formData = new FormData()
                    formData.append('email', this.email)

                    axios({
                        method: "post",
                        url: SITE_URL+"/app/controllers/inc/forgot-contr.php",
                        data: formData,
                    })
                        .then(response => {
                            this.errors = response.data
                            // console.log(response.data)
                        })
                        .catch(response => {
                            console.log(response.data)
                        })
                }

            }
        });
    }

    if ($('#newPassword').length) {
        new Vue({
            el: '#newPassword',
            data() {
                return {
                    newPassword: "",
                    newPasswordRepeat: "",
                    email: "",
                    errors: {},
                    pwdHidden: false
                }
            },
            delimiters: ['[[', ']]'],
            methods: {
                setNewPassword: function () {
                    let formData = new FormData()
                    formData.append('password', this.newPassword)
                    formData.append('passwordRepeat', this.newPasswordRepeat)
                    formData.append('email', this.email)

                    axios({
                        method: "post",
                        url: SITE_URL+"/app/controllers/inc/newpass-contr.php",
                        data: formData,
                    })
                        .then(response => {
                            this.errors = response.data
                            // console.log(response.data)
                            // console.log(Object.keys(response.data), Object.values(response.data))

                            if (response.data.length == 0)
                                window.location.href = "/phptutor/mvcproj/login"
                        })
                        .catch(response => {
                            console.log(response.data)
                        })
                }
            },
            mounted() {
                this.email = this.$refs.user_email.value
            }
        });
    }
});