<template>
<div>
    <form @submit.prevent="submitForm">
        <div class="input-group mb-3">
            <input id="idemaillogin" name="emaillogin" value="" type="email" class="form-control" v-model="fields.email" v-model.trim="$v.email.$model"
                   :class="{ 'is-invalid':$v.email.$error || errors.email, 'is-valid':(!sendSubmited && !$v.email.$invalid) || (!$v.email.$invalid && sendSubmited && !errors.email) }">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-envelope"></span>
                </div>
            </div>
            <div class="valid-feedback">Email é válido.</div>
            <div v-if="!errors.email" class="invalid-feedback">
                <span v-if="!$v.email.required">Email está vazio!</span>
                <span v-if="!$v.email.isUnique">Formato de email é inválido!</span>
            </div>
            <div v-else class="invalid-feedback">
                <span v-if="errors && errors.email">{{errors.email[0]}}</span>
            </div>
        </div>
        <div class="input-group mb-3">
            <input id="idpasswordlogin" name="passwordlogin" value="" type="password" class="form-control" placeholder="senha" v-model="fields.password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="single-input">
            <button type="submit" class="food__btn"><span>Login</span></button>
        </div>
    </form>
</div>
</template>

<script>
    import config from '../config';
    import {required, email} from 'vuelidate/lib/validators';
    export default {
        props: ['store'],
        data(){
            return {
                appUrl: config.APP_URL,
                appUrlDashboard: config.APP_URL_DASHBOARD,
                storeNew: this.store,
                email:  '',
                fields: {},
                errors: {},
                sendSubmited : false
            }
        },
        validations:{
            email:{
                required,
                email,
                isUnique(value) {
                    if(value === '') return true

                    let email_regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve(email_regex.test(value))
                        }, 350 + Math.random() * 300)
                    })
                }
            }
        },
        computed: {
        },
        methods:{
            async submitForm(){
                this.$v.$touch();
                this.sendSubmited = true;
                //let elbtnSubmit = document.getElementById('idspnsubmit');
                //elbtnSubmit.innerText = 'Enviando dados...';
                if(!this.$v.$invalid){
                    //alert('testandoooooooo');
                    this.fields.store = this.store.id;
                    await axios.post( this.appUrlDashboard+'/api/usuario/login/email',
                        this.fields
                    ).then(response => {
                        if(response.data.success === true){
                            this.fields = {};
                            this.errors = {};
                            this.$v.$reset();
                            toastr.success(response.data.message);
                        } else {
                            this.errors = {};
                            if(response.data.typeMessage == 'foneError'){
                                this.errors = {
                                    fone : {
                                        0 : response.data.message
                                    }
                                };
                                toastr.error('Verifique os dados!!!');
                            } else if(response.data.typeMessage == 'buildingError'){
                                this.errors = {
                                    building : {
                                        0 : response.data.message
                                    }
                                };
                                toastr.error('Verifique os dados!!!');
                            } else if(response.data.typeMessage == 'storeError'){
                                toastr.error(response.data.message);
                            }
                        }
                    }).catch(error => {
                        console.error(error.response.data);
                    });
                }
                //elbtnSubmit.innerText = 'Cadastrar';
            }
        },
        mounted() {
        }
    }
</script>
<style scoped>

</style>
