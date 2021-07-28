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
                    <div class="modal-footer">
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
                    <div class="modal-body modal-change-money-body">
                        <p class="text-center">O total do seu pedido é de R$ {{ listproductNew.totalPrice }}</p>
                        <p class="text-center">Digite quanto vai pagar em dinheiro para o seu troco.</p>
                        <div class="payment-cash-modal__input-container">
                            <div class="form-input">
                                <money v-model="changeOfMoneyPrice" v-bind="changeOfMoneyMoney"></money>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area bg-image--18">
            <div class="ht__bradcaump__wrap d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Finalizar pedido</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item" v-bind:href="appurlNew">Home</a>
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
                                                                         v-bind:src="appurlNew+'/site/images/icon/flags-payment/elo.png'"
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
                                                                             v-bind:src="appurlNew+'/site/images/icon/flags-payment/'+liststorepayment.type_payment_flag+'.png'"
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
import {Money} from 'v-money'
export default {
    components: {Money},

    props: ['listproduct', 'liststorepayment', 'appurl'],

    data() {
        return {
            listproductNew: this.listproduct,
            liststorepaymentNew: this.liststorepayment,
            appurlNew: this.appurl,
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
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
    methods: {
        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        selectPayment(e, typePaymentName, typePaymentDescription) {
            if (!this.notSelectedTypePayment) {
                $(".option-button").removeClass("option-button--active");
                //$(".option-button__check").remove();
            }
            let optionButtonPayment = e.currentTarget;
            optionButtonPayment.classList.add("option-button--active");
            //let spanCheck = $('<span data-test-id="option-button__check" class="option-button__check"><span class="icon-marmita icon-marmita--check-mark"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14"><path fill-rule="evenodd" d="M2.59 6.57A1 1 0 0 0 1.19 8l5.16 5.09L16.72 2.36A1 1 0 1 0 15.28.97l-8.96 9.28-3.73-3.68z" clip-rule="evenodd"></path></svg></span></span>');
            //optionButtonPayment.append(spanCheck);
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
        exeCheckOut() {
            if (this.selectedTypePaymentName !== null) {
                if (this.selectedTypePaymentName == 'paypal') {
                    window.location.href = this.appurlNew + '/paypal/pagar';
                    /*axios.post(
                        this.appurlNew+'/paypal/pagar'
                    ).then(response => {
                        if(response.data.success === true){
                            alert(response.data.message);
                            document.location.reload(true);
                        } else {
                            alert(response.data.message);
                        }
                    }).catch(error => {
                        alert('Erro ao fazer o pedido!!!');
                    });*/
                    /*$.ajax({
                        url: window.location.href = this.appurlNew + '/paypal/pagar',
                        type: "post",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function (response) {
                            if(response.success === true){
                                alert(response.data.message);
                                document.location.reload(true);
                            }else{
                                alert(response.data.message);
                            }
                            console.log(response);
                        }
                    });*/
                } else if (this.selectedTypePaymentName == 'dinheiro') {
                    axios.post( this.appurlNew+'/pedido/criar-pedido', {
                        type_payment : this.selectedTypePaymentDescription,
                        money_change: this.changeOfMoney
                    }).then(response => {
                        if(response.data.success === true){
                            alert(response.data.message);
                            window.location.href= ''+this.appurlNew+'/';
                        } else {
                            alert(response.data.message);
                        }
                    }).catch(error => {
                        alert('Erro ao fazer o pedido!!!');
                    });
                } else {
                    axios.post( this.appurlNew+'/pedido/criar-pedido', {
                        type_payment : this.selectedTypePaymentDescription
                    }).then(response => {
                        if(response.data.success === true){
                            alert(response.data.message);
                            window.location.href= ''+this.appurlNew+'/';
                        } else {
                            //alert(response.data.message);
                            console.log(response.data.message);
                        }
                    }).catch(error => {
                        alert('Erro ao fazer o pedido!!!');
                    });
                }
            }
        }
    },
    mounted() {

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
</style>
