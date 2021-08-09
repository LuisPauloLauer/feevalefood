<template>
    <div>
        <!-- Modal Delete -->
        <div id="idModalDemand" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" v-for="(demand, index) in demandFilter">
                    <div class="modal-header modal-header-demand">
                        <div class="container text-center modal-title-demand">
                            <h4 class="modal-title">Pedido N° {{demand.demand}}</h4>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container modal-body-demand-itens">
                            <ul>
                                <li class="order-details-cart__item" v-for="(demandItens, index) in demandItensFilter">
                                    <div class="order-details-cart__item-name order-details__justified">
                                        <span v-if="demandItens.kit_name">{{demandItens.kit_name}} x{{demandItens.amount}}</span>
                                        <span v-else>{{demandItens.product_name}} x{{demandItens.amount}}</span>
                                        <span v-if="demandItens.kit_price">R$&nbsp;{{ formatPrice(demandItens.kit_price * demandItens.amount) }}</span>
                                        <span v-else>R$&nbsp;{{ formatPrice(demandItens.product_price * demandItens.amount) }}</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="order-details-cart__footer">
                                <p class="order-details-cart__total-amount order-details__justified">
                                    <span>Total</span>
                                    <span>R$&nbsp;{{formatPrice(demand.total_price)}}</span>
                                </p>
                            </div>
                            <section class="order-details-more">
                                <p class="order-details__text">
                                    <span class="order-details__label">Data do pedido </span><span>{{ demand.created_at_date }} • {{ demand.created_at_hour }}</span>
                                </p>
                                <p class="order-details__text">
                                    <span class="order-details__label">Pagamento</span>
                                    <span v-if="demand.type_payment == 'paypal'">Pagamento pelo site • {{ demand.type_payment }}</span>
                                    <span v-else>Pagamento na entrega • {{ demand.type_payment }}</span>
                                </p>
                                <p class="order-details__text" v-if="demand.type_payment == 'Dinheiro'">
                                    <span class="order-details__label">Troco</span><span>R$&nbsp;{{ formatPrice(demand.money_change) }}</span>
                                </p>
                                <p class="order-details__text">
                                    <span class="order-details__label">Status do pedido:</span><span>{{ demand.status_name }}</span>
                                </p>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Modal Delete -->

        <div class="container" style="min-height: 900px">
            <div class="mt--15">
                <h3>Meus pedidos</h3>
                <div class="checkout-section mt--30">
                    <div class="container">
                        <div class="row">
                            <!-- Order Details -->
                            <div v-for="(listdemand, index) in listdemandNew" class="col-lg-6 col-12 mb--30">
                                <div class="order-details-wrapper">
                                    <div class="order-details-wrapper-header-demand" @click="showModalDemand(listdemand.demand)"><h2>Pedido Nº {{listdemand.demand}} -- {{listdemand.status_name}}</h2></div>
                                    <div class="order-details">
                                        <form action="#">
                                            <ul>
                                                <li>
                                                    <p class="strong">Produtos</p>
                                                    <p class="strong">total</p>
                                                </li>
                                                    <li v-for="(listdemanditens, index) in listdemanditensNew" v-if="listdemanditens.demand == listdemand.demand">
                                                        <p v-if="listdemanditens.kit_name">{{listdemanditens.kit_name}} x{{listdemanditens.amount}}</p>
                                                        <p v-else>{{listdemanditens.product_name}} x{{listdemanditens.amount}}</p>
                                                        <p v-if="listdemanditens.kit_price">R$&nbsp;{{ formatPrice(listdemanditens.kit_price * listdemanditens.amount) }}</p>
                                                        <p v-else>R$&nbsp;{{ formatPrice(listdemanditens.product_price * listdemanditens.amount) }}</p>
                                                    </li>
                                                <li>
                                                    <p class="strong">Pedido Total</p>
                                                    <p class="strong">R$&nbsp;{{formatPrice(listdemand.total_price)}}</p>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {

    props: ['listdemand', 'listdemanditens', 'appurl'],

    data() {
        return {
            listdemandNew: this.listdemand,
            listdemanditensNew: this.listdemanditens,
            appurlNew: this.appurl,
            demandFilter: this.listdemand,
            demandItensFilter: this.listdemanditens,
            csrf: document.head.querySelector('meta[name="csrf-token"]').content
        }
    },
    methods: {
        formatPrice(value) {
            let val = (value / 1).toFixed(2).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        },
        showModalDemand(pDemand){
            //this.demandFilter = this.listdemandNew;
            //this.demandItensFilter = this.listdemanditensNew;
            this.demandFilter = Object.values(this.listdemand).filter(demandFiltered => demandFiltered.demand === pDemand);
            this.demandItensFilter = Object.values(this.listdemanditens).filter(itemFiltered => itemFiltered.demand === pDemand);

            console.log(this.demandFilter);
            console.log(this.demandItensFilter);

            $('#idModalDemand').modal('show');

        }
    },
    mounted() {
        //console.log(this.listdemandNew);
        //console.log(this.listdemanditensNew);
    }
}

</script>

<style scoped>
    .order-details-wrapper-header-demand:hover{
        cursor: pointer;
    }
    .order-details-cart__item-name {
        font-weight: 500;
        color: #3f3e3e;
    }
    .order-details__justified, .order-details__text {
        display: flex;
        justify-content: space-between;
    }
    .modal-body-demand-itens{
        max-width: 550px;
    }
    .order-details-cart__item {
        border-top: 1px solid #f6f5f5;
        padding: 15px 0;
    }
    .modal-header-demand{
        border-bottom: 0;
    }
    .order-details-cart__item:last-child {
        border-bottom: 1px solid #f6f5f5;
    }
    .order-details-cart__footer {
        padding: 10px 0;
        line-height: 1.8em;
        border-bottom: 1px solid #f5f0eb;
    }
    .order-details-cart__total-amount {
        font-size: 1rem;
        font-weight: 500;
        color: #3f3e3e;
    }
    .order-details-more {
        padding: 10px 0;
        background-color: white;
        margin-bottom: 10px;
    }
    .order-details__text {
        font-weight: 100;
        line-height: 1.625rem;
        margin: 0;
        color: #3e3e3e;
    }
    .order-details__text {
        flex-direction: column;
        border-bottom: 1px solid #f6f5f5;
        padding: 10px 0;
    }
    .order-details__label {
        color: #717171;
        font-weight: 300;
        font-size: 1rem;
        line-height: normal;
        margin: 0;
    }
    .order-details__label:first-child {
        text-align: left;
    }
    .order-details__label:first-child ~ :last-child {
        text-align: right;
        color: #3e3e3e;
    }
    .order-details__label:first-child ~ :last-child {
        text-align: left;
    }
</style>
