new Vue({
    el: '#loginApp',
    data() {
        return {
            login: "",
            password: "",
            errors: {}
        }
    },
    delimiters: ['[[',']]'],
    methods: {
        doLogin: function (){
            let formData = new FormData();
            formData.append('login',this.login)
            formData.append('password',this.password)

            axios({
                method: "post",
                url: "app/controllers/login/loginControllerHandle.php",
                data: formData
            })
                .then(response=>{
                    this.errors = response.data
                    console.log(this.errors)

                    if (response.data.length == 0)
                        window.location.href = "/phptutor/mvcproj/"
                })
        }
    }
});

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
    delimiters: ['[[',']]'],
    methods: {
        signUp: function (){
            let formData = new FormData()
            formData.append('login',this.login)
            formData.append('password',this.password)
            formData.append('passwordRepeat',this.passwordRepeat)
            formData.append('email',this.email)

            axios({
                method: "post",
                url: "app/controllers/login/signUpControllerHandle.php",
                data: formData,
            })
                .then(response=>{
                    this.errors = response.data
                    console.log(response.data)
                    console.log(Object.keys(response.data),Object.values(response.data))

                    if (response.data.length == 0)
                        this.success = true;
                })
                .catch(response=>{
                    console.log(response.data)
                })
        }
    }
});

Vue.component('product-card', {
    props: ['product'],
    delimiters: ['[[',']]'],
    template: `
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <li class="card h-100">
                <div class="card-body">
                    <figure>
                        <img loading="lazy" :src="[[ product.image ]]" :title="[[ product.name ]]" :alt="[[ product.name ]]" class="card-img-top">
                    </figure>
                    <h5 class="card-title">[[ product.name ]]</h5>
                    <span class="text-success size-lg">$[[ product.price ]]</span>
                </div>
                <div class="card-footer">
                    [[ product.pub_date ]]
                </div>
            </li>
        </div>
    `
});

new Vue({
    el: "#account",
    delimiters: ['[[',']]'],
    data(){
        return{
            categories: [],
            products: [],
            ordering: "pub_date|asc"
        }
    },
    methods: {
        getAllProducts: function(){
            axios.get('app/controllers/loadController.php?category=product')
                .then(response=>{
                    this.products = response.data
                })
        },
        doFilter: function(){
            axios.get('app/controllers/filter/filterController.php?categories='+this.categories+"&ordering="+this.ordering)
                .then(response=>{
                    // console.log(response.data)
                    this.products = response.data
                })
        }

    },
    created(){
        this.getAllProducts()
    }
})

new Vue({
    el: '#resetPassword',
    data() {
        return {
            email: "",
            errors: {}
        }
    },
    delimiters: ['[[',']]'],
    methods: {
        doReset: function (){
            let formData = new FormData()
            formData.append('email',this.email)

            axios({
                method: "post",
                url: "app/controllers/login/forgotPasswordControllerHandle.php",
                data: formData,
            })
                .then(response=>{
                    this.errors = response.data
                    console.log(response.data)
                    console.log(Object.keys(response.data),Object.values(response.data))
                })
                .catch(response=>{
                    console.log(response.data)
                })
        }

    }
});

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
    delimiters: ['[[',']]'],
    methods: {
        setNewPassword: function (){
            let formData = new FormData()
            formData.append('password',this.newPassword)
            formData.append('passwordRepeat',this.newPasswordRepeat)
            formData.append('email',this.email)

            axios({
                method: "post",
                url: "app/controllers/login/newPasswordController.php",
                data: formData,
            })
                .then(response=>{
                    this.errors = response.data
                    console.log(response.data)
                    console.log(Object.keys(response.data),Object.values(response.data))

                    if (response.data.length == 0)
                        window.location.href = "/phptutor/mvcproj/login"
                })
                .catch(response=>{
                    console.log(response.data)
                })
        }
    },
    mounted() {
        this.email = this.$refs.user_email.value
    }
});