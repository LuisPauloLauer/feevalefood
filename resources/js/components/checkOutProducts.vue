<template>
    <div>
        <!-- Start modal change of money -->
        <div id="idModalChangeMoney" class="modal fade" role="dialog">
            <div class="modal-change-money modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content modal-change-money-content">
                    <div class="modal-header modal-change-money-header">
                        <div class="container text-center">
                            <h4 class="modal-title" align="center">Opção {{ this.selectedTypePaymentDescription }}</h4>
                        </div>
                    </div>
                    <div class="modal-body modal-change-money-body">
                        <h5 align="center" style="margin:0;">Você vai precisar de troco?</h5>
                    </div>
                    <div class="modal-footer modal-change-money-footer">
                        <div class="container text-center">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                            <button type="button" class="btn btn-danger" id="idModalChangeMoneyYes"
                                    @click="showModalChangeOfMoneyPrice">Sim
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal change of money -->
        <!-- Start modal change of money -->
        <div id="idModalChangeMoneyPrice" class="modal fade" role="dialog" @click.self="onCloseModalChangeMoneyPrice">
            <div class="modal-change-money-price modal-dialog modal-dialog-centered">
                <div class="modal-content modal-change-money-price-content">
                    <div class="modal-header modal-change-money-price-header">
                        <div class="container text-center">
                            <h4 class="modal-title" align="center">Troco pra quanto?</h4>
                        </div>
                    </div>
                    <div class="modal-body modal-change-money-price-body">
                        <p class="text-center">O total do seu pedido é de R$ {{ listproductNew.totalPrice }}</p>
                        <p class="text-center">Digite quanto vai pagar em dinheiro para o seu troco.</p>
                        <div class="payment-cash-modal__input-container">
                            <div class="form-input">
                                <money v-model="changeOfMoneyPrice" v-bind="changeOfMoneyMoney"></money>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-change-money-price-footer">
                        <div class="container text-center">
                            <button
                                :disabled="(parseFloat(changeOfMoneyPrice) <=  parseFloat(listproductNew.totalPrice))" type="button" class="container btn btn-danger" id="idModalChangeMoneyConfirm" @click="confirmOfMoneyPrice">Confirmar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal change of money -->
        <!-- Start modal change of money -->
        <div id="idModalWhatsapp" class="modal fade" role="dialog" @click.self="onCloseModalWhats">
            <div class="modal-whatsapp modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content modal-whatsapp-content">
                    <div class="modal-header modal-whatsapp-header">
                        <div class="container text-center">
                            <h5>Pedido N° {{ notificatios.demand }}</h5>
                        </div>
                    </div>
                    <div class="modal-body modal-change-money-body">
                        <div class="container-fluid">
                            <div class="card-body text-center">
                                <h5> Olá {{ usersiteNew.name }}</h5>
                                <h5>Ocorreu um erro ao enviar a mensagem de aviso do pedido {{ notificatios.demand }} para o whatsApp da loja.</h5>
                                <h5>Por favor contate com a loja pelo numero: <span id="phone-mask-whatsapp" v-html="notificatios.phone"></span></h5>
                                <h5>Ou diretamente pelo whatsApp clicando no link abaixo:</h5>
                                <a v-bind:href="notificatios.linkWhatsapp" target="_blank" type="button" class="btn btn-success"  data-mdb-ripple-color="dark">
                                    Enviar mensagem <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-whatsapp-footer">
                        <div class="container text-center">
                            <h5>Para ver o seu pedido clique no link abaixo:</h5>
                            <a class="btn btn-danger" v-bind:href="appUrl+'/pedidos'">Ver pedido</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal change of money -->
        <!-- Start modal change of money -->
        <div id="idModalStoreOpen" class="modal fade" role="dialog">
            <div class="modal-store-open modal-dialog modal-dialog-centered">
                <div class="modal-content modal-store-open-content">
                    <div class="modal-header modal-store-open-header">
                        <div class="container text-center">
                            <h4 class="modal-title" align="center">Loja está fechada</h4>
                        </div>
                    </div>
                    <div class="modal-body modal-store-open-body">
                        <h5 align="center" style="margin:0;">Clique abaixo para voltar para home page</h5>
                    </div>
                    <div class="modal-footer modal-store-open-footer">
                        <div class="container text-center">
                            <a class="btn btn-danger" v-bind:href="appUrl">Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area bg-image--18">
            <div class="ht__bradcaump__wrap d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Finalizar pedido</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" v-bind:href="appUrl">Home</a>
                                    <span class="brd-separetor"><i class="fa fa-long-arrow-right"></i></span>
                                    <span class="breadcrumb-item active">Checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <section class="htc__checkout bg--white section-padding--lg">
            <!-- Checkout Section Start-->
            <div class="checkout-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-30">
                            <!-- Checkout Accordion Start -->
                            <div id="checkout-accordion">
                                <!-- Checkout Method -->
                                <div class="single-accordion">
                                    <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                                       href="#checkout-method">Opções de Pagamento</a>
                                    <div id="checkout-method" class="collapse show">
                                        <div class="checkout-method accordion-body fix">
                                            <ul class="nav accountbox__filters" id="myTab" role="tablist">
                                                <li>
                                                    <a class="active" id="log-tab" data-toggle="tab" href="#log"
                                                       role="tab" aria-controls="log" aria-selected="true">Pelo Site</a>
                                                </li>
                                                <li>
                                                    <a id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                                       aria-controls="profile" aria-selected="false" class="">Na
                                                        Entrega</a>
                                                </li>
                                            </ul>
                                            <div class="accountbox__inner tab-content" id="myTabContent">
                                                <div class="tab-pane fade active show" id="log" role="tabpanel"
                                                     aria-labelledby="log-tab">
                                                    <div>
                                                        <div class="offline-payment-list">
                                                            <div class="offline-payment-list__options">
                                                                <button type="button"
                                                                        class="btn btn--default btn--size-m option-button"
                                                                        @click="selectPayment($event,'paypal','PayPal')">
                                                                    <img class="option-button__icon"
                                                                         v-bind:src="appUrl+'/site/images/icon/flags-payment/elo.png'"
                                                                         alt="" crossorigin="anonymous">
                                                                    <div class="option-button__description">
                                                                        <div class="option-button__description-text">
                                                                            <span>Paypal</span>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel"
                                                     aria-labelledby="profile-tab">
                                                    <div>
                                                        <div class="offline-payment-list">
                                                            <div class="offline-payment-list__options">
                                                                <div
                                                                    v-for="(liststorepayment, index) in liststorepaymentNew">
                                                                    <button type="button"
                                                                            class="btn btn--default btn--size-m option-button"
                                                                            @click="selectPayment($event,liststorepayment.type_payment_name,liststorepayment.type_payment_description)">
                                                                        <img class="option-button__icon"
                                                                             v-bind:src="appUrl+'/site/images/icon/flags-payment/'+liststorepayment.type_payment_flag+'.png'"
                                                                             alt="" crossorigin="anonymous">
                                                                        <div class="option-button__description">
                                                                            <div
                                                                                class="option-button__description-text">
                                                                                <span>{{ liststorepayment.type_payment_description }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Checkout Accordion Start -->
                        </div>
                        <!-- Order Details -->
                        <div class="col-lg-6 col-12 mb-30">
                            <div class="order-details-wrapper">
                                <h2>Seu pedido</h2>
                                <div class="order-details">
                                    <form>
                                        <ul>
                                            <li><p class="strong">Produtos</p>
                                                <p class="strong">total</p></li>
                                            <li v-for="(listproduct, index) in listproductNew.items">
                                                <p>{{ listproduct.item.name }} x{{ listproduct.qty }}</p>
                                                <p>R$ {{ formatPrice(listproduct.price) }}</p>
                                            </li>
                                            <li v-if="listproductNew.subTotalPrice !== listproductNew.totalPrice"><p class="strong">pedido subtotal</p>
                                                <p class="strong">R$ {{ formatPrice(listproductNew.subTotalPrice) }}</p></li>
                                            <li v-if="listproductNew.shipping > 0"><p class="strong">pedido frete</p>
                                                <p class="strong">R$ {{ formatPrice(listproductNew.shipping) }}</p></li>
                                            <li v-if="listproductNew.percDiscount > 0"><p class="strong">pedido desconto</p>
                                                <p class="strong">{{ formatPrice(listproductNew.percDiscount) }} %</p></li>
                                            <li><p class="strong">pedido total</p>
                                                <p class="strong">R$ {{ formatPrice(listproductNew.totalPrice) }}</p></li>
                                        </ul>
                                    </form>
                                    <button class="container btn btn-danger" :disabled="notSelectedTypePayment"
                                            @click="exeCheckOut"><span>Fazer pedido</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Checkout Section End-->
        </section>
    </div>
</template>

<script>
    import config from '@/utils/config';
    import {Money} from 'v-money';
    export default {
        components: {Money},
        props: ['usersite', 'listproduct', 'liststorepayment'],
        data() {
            return {
                appUrl: config.APP_URL,
                appUrlDashboard: config.APP_URL_DASHBOARD,
                usersiteNew: this.usersite,
                listproductNew: this.listproduct,
                liststorepaymentNew: this.liststorepayment,
                isStoreOpen : false,
                notSelectedTypePayment: true,
                selectedTypePaymentName: null,
                selectedTypePaymentDescription: null,
                changeOfMoney : 0,
                changeOfMoneyPrice: 0,
                changeOfMoneyMoney: {
                    decimal: ',',
                    thousands: '.',
                    prefix: 'R$ ',
                    suffix: '',
                    precision: 2,
                    masked: false
                },
                notificatios: {
                    demand: null,
                    phone: '',
                    message: '',
                    linkWhatsapp: ''
                },
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },
        methods: {
            async getStoreOpen(){
                const  response = await axios.get(this.appUrlDashboard+'/api/store/delivery/status/2');
                if(response.status == 200){
                    if(response.data.success){
                        return response.data.isStoreOpen;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            },
            onCloseModalWhats(){
                window.location.href= ''+this.appUrl+'/pedidos';
            },
            formatPrice(value) {
                let val = (value / 1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            selectPayment(e, typePaymentName, typePaymentDescription) {
                if (!this.notSelectedTypePayment) {
                    $(".option-button").removeClass("option-button--active");
                }
                let optionButtonPayment = e.currentTarget;
                optionButtonPayment.classList.add("option-button--active");
                this.notSelectedTypePayment = false;
                this.selectedTypePaymentName = typePaymentName;
                this.selectedTypePaymentDescription = typePaymentDescription;
                if (this.selectedTypePaymentName === 'dinheiro') {
                    $('#idModalChangeMoney').modal('show');
                }
            },
            showModalChangeOfMoneyPrice() {
                $('#idModalChangeMoney').modal('hide');
                $('#idModalChangeMoneyPrice').modal('show');
            },
            onCloseModalChangeMoneyPrice(){
                if(this.changeOfMoneyPrice <= parseFloat(this.listproductNew.totalPrice)){
                    this.changeOfMoney = 0;
                    this.changeOfMoneyPrice = 0;
                }
            },
            confirmOfMoneyPrice() {
                if(this.changeOfMoneyPrice <= parseFloat(this.listproductNew.totalPrice)){
                    alert('Erro, troco deve ser maior do que o valor do pedido');
                    this.changeOfMoney = 0;
                    this.changeOfMoneyPrice = 0;
                } else {
                    this.changeOfMoney = this.changeOfMoneyPrice;
                    $('#idModalChangeMoneyPrice').modal('hide');
                }
            },
            async exeCheckOut() {
                if(await this.getStoreOpen()){
                    if (this.selectedTypePaymentName !== null) {
                        if (this.selectedTypePaymentName == 'paypal') {
                            window.location.href = this.appUrl+'/paypal/pagar';
                            /*
                             axios.get( this.appUrl+'/paypal/pagar'
                            ).then(response => {
                                if(response.data.success === true){
                                    axios.get( this.appUrl+'/send-message/whatsapp/'+response.data.idDemand).then(response => {
                                        if(response.data.success === true){
                                            window.location.href= ''+this.appUrl+'/pedidos';
                                        } else {
                                            alert(response.data.message);
                                            window.location.href= ''+this.appUrl+'/pedidos';
                                        }
                                    }).catch(error => {
                                        alert('Erro ao mandar mensagem!!!');
                                        window.location.href= ''+this.appUrl+'/pedidos';
                                    });
                                } else {
                                    alert(response.data.message);
                                }
                            }).catch(error => {
                                alert('Erro ao fazer o pedido!!!');
                            }); */
                        } else if (this.selectedTypePaymentName == 'dinheiro') {
                            axios.post( this.appUrl+'/pedido/criar-pedido', {
                                type_payment : this.selectedTypePaymentDescription,
                                money_change: this.changeOfMoney
                            }).then(response => {
                                if(response.data.success === true){
                                    this.notificatios.demand = response.data.idDemand;
                                    axios.get( this.appUrl+'/send-message/whatsapp/'+response.data.idDemand).then(response => {
                                        if(response.data.success === true){
                                            window.location.href= ''+this.appUrl+'/pedidos';
                                        } else {
                                            this.notificatios.phone = response.data.phone;
                                            this.notificatios.message = response.data.message;
                                            this.notificatios.linkWhatsapp = response.data.messagelink;
                                            $('#phone-mask-whatsapp').mask('(00) 00000-0000');
                                            $('#idModalWhatsapp').modal('show');
                                        }
                                    }).catch(error => {
                                        $('#phone-mask-whatsapp').mask('(00) 00000-0000');
                                        $('#idModalWhatsapp').modal('show');
                                    });
                                } else {
                                    alert(response.data.message);
                                }
                            }).catch(error => {
                                alert('Erro ao fazer o pedido!!!');
                            });
                        } else {
                            axios.post( this.appUrl+'/pedido/criar-pedido', {
                                type_payment : this.selectedTypePaymentDescription
                            }).then(response => {
                                if(response.data.success === true){
                                    this.notificatios.demand = response.data.idDemand;
                                    axios.get( this.appUrl+'/send-message/whatsapp/'+response.data.idDemand).then(response => {
                                        if(response.data.success === true){
                                            window.location.href= ''+this.appUrl+'/pedidos';
                                        } else {
                                            this.notificatios.phone = response.data.phone;
                                            this.notificatios.message = response.data.message;
                                            this.notificatios.linkWhatsapp = response.data.messagelink;
                                            $('#phone-mask-whatsapp').mask('(00) 00000-0000');
                                            $('#idModalWhatsapp').modal('show');
                                        }
                                    }).catch(error => {
                                        $('#phone-mask-whatsapp').mask('(00) 00000-0000');
                                        $('#idModalWhatsapp').modal('show');
                                    });
                                } else {
                                    alert(response.data.message);
                                }
                            }).catch(error => {
                                alert('Erro ao fazer o pedido!!!');
                            });
                        }
                    }
                } else {
                    $('#idModalStoreOpen').modal('show');
                }
            }
        },
        mounted() {
            this.isStoreOpen = this.getStoreOpen();
        }
    }
</script>
<style>
    .payment-cash-modal__input-container {
        font-size: 1.375rem;
        color: #a6a5a5;
        font-weight: bold;
        display: flex;
        align-items: baseline;
        justify-content: center;
    }
    .modal-change-money-header, .modal-change-money-price-header, .modal-whatsapp-header, .modal-store-open-header{
        border-bottom: 0;
    }
    .modal-change-money-footer, .modal-change-money-price-footer, .modal-whatsapp-footer, .modal-store-open-footer{
        border-top: 0;
    }
</style>
