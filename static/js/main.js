$(document).ready(function(){
    Vue.component('cart-product-card', {
        props: ['products'],
        delimiters: ['[[', ']]'],
        data() {
            return {}
        },
        methods: {
            removeFromCart: function (id){
                axios.get('app/controllers/cart/removeFromCartController.php?id='+id)
                  .then(response => {
                      console.log(response.data)
                      account.getCart()
                  })
            },
            clearCart: function (){
                axios.get('app/controllers/cart/clearCartController.php?')
                    .then(response => {
                        console.log(response.data)
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
    Vue.component('product-card', {
        props: ['product'],
        delimiters: ['[[', ']]'],
        data() {
            return {
                errored: false,
                response: {}
            }
        },
        methods: {
            addToCart: function (id) {
                let url = "app/controllers/cart/cartController.php?pid=" + id
                axios
                    .get(url)
                    .then(response => {
                        this.response = response.data
                        account.getCart()
                        $('#exampleModal').modal('show')
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
                    <span class="text-success size-lg">$[[ product.price ]]</span>
                </div>
                <div class="card-footer">
                    
                    <button class="btn btn-primary" @click="addToCart(product.id)">
                        Add to cart
                        
                        <!-- empty icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                         
                    </button>
                    <p class="text-danger" v-if="errored">Sorry, something went wrong.</p>
                    <p class="text-danger" v-if="response.productAlreadyAdded">This product already in cart.</p>
                </div>
            </li>
        </div>
    `
    });

    if ($('#loginApp').length) {
        new Vue({
            el: '#loginApp',
            data() {
                return {
                    login: "",
                    password: "",
                    errors: {}
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
                        url: "app/controllers/login/loginControllerHandle.php",
                        data: formData
                    })
                        .then(response => {
                            this.errors = response.data
                            console.log(this.errors)

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
                    success: false
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
                        url: "app/controllers/login/signUpControllerHandle.php",
                        data: formData,
                    })
                        .then(response => {
                            this.errors = response.data
                            console.log(response.data)
                            console.log(Object.keys(response.data), Object.values(response.data))

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
    if ($('#account').length) {
        var account = new Vue({
            el: "#account",
            delimiters: ['[[', ']]'],
            data() {
                return {
                    categories: [],
                    products: [],
                    ordering: "pub_date|asc",
                    cartProducts: [],
                    cartCount: 0,
                    totals: 0
                }
            },
            methods: {
                getAllProducts: function () {
                    axios.get('app/controllers/loadController.php?table=product')
                        .then(response => {
                            this.products = response.data
                            // console.log(this.products)
                        })
                },
                doFilter: function () {
                    axios.get('app/controllers/filter/filterController.php?categories=' + this.categories + "&ordering=" + this.ordering)
                        .then(response => {
                            // console.log(response.data)
                            this.products = response.data
                        })
                },
                getCart: function () {
                    axios.get('app/controllers/cart/loadCartController.php')
                        .then(response => {
                            this.cartProducts = response.data[0]
                            this.cartCount = response.data[1]
                            this.totals = response.data[2]
                            console.log(this.cartProducts)
                        })
                }

            },
            created() {
                this.getAllProducts()
                this.getCart()
            }
        })
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
                        url: "app/controllers/login/forgotPasswordControllerHandle.php",
                        data: formData,
                    })
                        .then(response => {
                            this.errors = response.data
                            // console.log(response.data)
                            // console.log(Object.keys(response.data),Object.values(response.data))
                        })
                        .catch(response => {
                            // console.log(response.data)
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
                    errors: {}
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
                        url: "app/controllers/login/newPasswordController.php",
                        data: formData,
                    })
                        .then(response => {
                            this.errors = response.data
                            console.log(response.data)
                            console.log(Object.keys(response.data), Object.values(response.data))

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