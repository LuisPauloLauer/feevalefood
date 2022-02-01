<template>
<div>
    <form @submit.prevent="submitForm">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Nome:</label>
                <input id="idnameRegUser" name="name" value="" type="text" class="form-control" @keypress="sanitize('name')" v-model="fields.name" v-model.trim="$v.name.$model"
                       :class="{ 'is-invalid':$v.name.$error || errors.name, 'is-valid':(!sendSubmited && !$v.name.$invalid) || (!$v.name.$invalid && sendSubmited && !errors.name) }">
                <div class="valid-feedback">Nome é válido.</div>
                <div v-if="!errors.name" class="invalid-feedback">
                    <span v-if="!$v.name.required">Nome está vazio!</span>
                    <span v-if="!$v.name.minLength">Nome deve ter pelo menos {{$v.name.$params.minLength.min}} letras!</span>
                    <span v-if="!$v.name.maxLength">Nome deve ter no máximo {{$v.name.$params.maxLength.max}} letras!</span>
                </div>
                <div v-else class="invalid-feedback">
                    <span v-if="errors && errors.name">{{errors.name[0]}}</span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Email:</label>
                <input id="idemailRegUser" name="email" value="" type="email" class="form-control" @keypress="sanitize('email')" v-model="fields.email" v-model.trim="$v.email.$model"
                       :class="{ 'is-invalid':$v.email.$error || errors.email, 'is-valid':(!sendSubmited && !$v.email.$invalid) || (!$v.email.$invalid && sendSubmited && !errors.email) }">
                <div class="valid-feedback">Email é válido.</div>
                <div v-if="!errors.email" class="invalid-feedback">
                    <span v-if="!$v.email.required">Email está vazio!</span>
                    <span v-if="!$v.email.isUnique">Formato de email é inválido!</span>
                </div>
                <div v-else class="invalid-feedback">
                    <span v-if="errors && errors.email">{{errors.email[0]}}</span>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <div class="pwd-reg-user">
                    <label>Senha:</label>
                    <span class="pwd-reg-user-spn">Mostrar senha:</span>
                    <input type="checkbox" id="showpassword" class="form-check-input" @click="toggleShowPassword" v-model="showpassword">
                </div>
                <input id="idpasswordRegUser" name="password" value="" type="password" class="form-control" @keypress="sanitize('password')" v-model="fields.password" v-model.trim="$v.password.$model"
                       :class="{ 'is-invalid':$v.password.$error || errors.password, 'is-valid':(!sendSubmited && !$v.password.$invalid) || (!$v.password.$invalid && sendSubmited && !errors.password) }">
                <div class="valid-feedback">Sua senha é válida.</div>
                <div v-if="!errors.password" class="invalid-feedback">
                    <span v-if="!$v.password.required">Senha está vazia!</span>
                    <span v-if="!$v.password.minLength">Senha deve ter pelo menos {{$v.password.$params.minLength.min}} dígitos!</span>
                </div>
                <div v-else class="invalid-feedback">
                    <span v-if="errors && errors.password">{{errors.password[0]}}</span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Confirmar senha:</label>
                <input id="idconfirmpasswordRegUser" name="password_confirmation" value="" type="password" class="form-control" v-model="fields.password_confirmation" v-model.trim="$v.repeatpassword.$model"
                       :class="{ 'is-invalid':$v.repeatpassword.$error, 'is-valid': (password != '') ? !$v.repeatpassword.$invalid : '' }">
                <div class="valid-feedback">Senhas são identicas.</div>
                <div class="invalid-feedback">
                    <span v-if="!$v.repeatpassword.sameAsPassword">Senhas devem ser iguais!</span>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Celular:</label>
                <input id="idfoneRegUser" name="fone" value="" type="text" class="form-control phone-mask" placeholder="Ex.: (51) 98888-8888" v-model="fields.fone" v-model.trim="$v.fone.$model"
                       :class="{ 'is-invalid':$v.fone.$error || errors.fone, 'is-valid':(!sendSubmited && !$v.fone.$invalid) || (!$v.fone.$invalid && sendSubmited && !errors.fone) }">
                <div class="valid-feedback">Celular é válido.</div>
                <div v-if="!errors.fone" class="invalid-feedback">
                    <span v-if="!$v.fone.required">Celular está vazio!</span>
                    <span v-if="!$v.fone.minLength">Celular deve ter pelo menos {{$v.fone.$params.minLength.min}} dígitos!</span>
                </div>
                <div v-else class="invalid-feedback">
                    <span v-if="errors && errors.fone">{{errors.fone[0]}}</span>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Selecione uma empresa:</label>
                <select name="building" class="custom-select" @mousedown="onMousedown" @change="onchange" @blur="onBlur" v-model="fields.building" v-model.trim="$v.selectbuilding.$model"
                        :class="{ 'is-invalid':$v.selectbuilding.$error || errors.building, 'is-valid':(!sendSubmited && !$v.selectbuilding.$invalid) || (!$v.selectbuilding.$invalid && sendSubmited && !errors.building) }">
                    <option value=""></option>
                    <option v-for="(building, index) in buildings" :value=building.id>{{building.company_name}}</option>
                </select>
                <div class="valid-feedback">Empresa selecionada.</div>
                <div v-if="!errors.building" class="invalid-feedback">
                    <span v-if="!$v.selectbuilding.required">Selecione uma empresa!</span>
                </div>
                <div v-else class="invalid-feedback">
                    <span v-if="errors && errors.building">{{errors.building[0]}}</span>
                </div>
            </div>
        </div>
        <div class="single-input">
            <button id="idbtnsubmit" type="submit" class="food__btn"><span id="idspnsubmit">Cadastrar</span></button>
        </div>
    </form>
</div>
</template>

<script>
    import config from '@/utils/config';
    import {required, minLength, maxLength, email, sameAs } from 'vuelidate/lib/validators';
    export default {
        props: ['store'],
        data(){
            return {
                appUrl: config.APP_URL,
                appUrlDashboard: config.APP_URL_DASHBOARD,
                storeNew: this.store,
                name:   '',
                email:  '',
                password: '',
                repeatpassword: '',
                showpassword: false,
                fone: '',
                selectbuilding: '',
                buildings: {},
                fields: {},
                errors: {},
                sendSubmited: false
            }
        },
        validations:{
            name:{
                required,
                minLength: minLength(4),
                maxLength: maxLength(240)
            },
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
            },
            password:{
                required,
                minLength: minLength(8)
            },
            repeatpassword:{
                sameAsPassword: sameAs('password')
            },
            fone:{
                required,
                minLength: minLength(11)
            },
            selectbuilding:{
                required
            }
        },
        computed: {
        },
        methods:{
            async getBuildings(){
                const  response = await axios.get(this.appUrlDashboard+'/api/usuario/retorna-predios');
                if(response.status == 200){
                    if(response.data.success){
                        this.buildings = response.data.buildings;
                    } else {
                        console.error(response.data.message);
                    }
                } else {
                    console.error('Erro ao buscar prédios pelo método');
                }
            },
            toggleShowPassword(){
                let elIdPassword = document.getElementById('idpasswordRegUser');
                if(this.showpassword == false){
                    this.showpassword = true
                    elIdPassword.type = 'text'
                } else {
                    this.showpassword = false
                    elIdPassword.type = 'password'
                }
            },
            async submitForm(){
                this.$v.$touch();
                this.sendSubmited = true;
                let elbtnSubmit = document.getElementById('idspnsubmit');
                elbtnSubmit.innerText = 'Enviando dados...';
                if(this.$v.$invalid){
                    toastr.error('Verifique os dados!!!');
                } else {
                    this.fields.store = this.store.id;
                    await axios.post( this.appUrlDashboard+'/api/usuario/registro/email',
                        this.fields
                    ).then(response => {
                        if(response.data.success === true){
                            this.resetForm();
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
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors;
                            toastr.error('Verifique os dados!!!');
                        } else {
                            this.errors = {};
                            console.error(error.response.data);
                        }
                    });
                }
                elbtnSubmit.innerText = 'Cadastrar';
            },
            onMousedown(event){
                event.target.size = 5;
            },
            onchange(event){
                this.sanitize('building');
                event.target.blur();
            },
            onBlur(event){
                event.target.size = 1;
            },
            sanitize(pField){
                switch (pField) {
                    case 'name':
                        this.errors.name = null;
                        break;
                    case 'email':
                        this.errors.email = null;
                        break;
                    case 'password':
                        this.errors.password = null;
                        break;
                    case 'fone':
                        this.errors.fone = null;
                        break;
                    case 'building':
                        this.errors.building = null;
                        break;
                    default:
                        console.log('Erro ao limpar fields (errors) ');
                }
            },
            resetForm(){
                this.name = '';
                this.email =  '';
                this.password = '';
                this.repeatpassword = '';
                this.showpassword = false;
                this.fone = '';
                this.selectbuilding = '';
                this.sendSubmited = false;
            }
        },
        mounted() {
            this.getBuildings();
        }
    }
</script>
<style scoped>
    .pwd-reg-user{
        display: inline-flex;
        align-content: space-between;
        align-items: stretch;
        justify-items: stretch;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-end;
    }
    .pwd-reg-user-spn{
        padding: 0px 15px;
    }
    #showpassword{
        margin-top: 8px;
    }
    .accountbox .single-input{
        margin-top: 0px;
    }
    .food__btn{
        width: -webkit-fill-available;
        height: 50px;
    }
</style>
