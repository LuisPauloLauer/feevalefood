<template>
    <!-- Start Modal CartBox -->
    <div class="cartbox-wrap">
        <div class="cartbox text-right">
            <button class="btn cartbox-close"><i class="fa fa-close"></i></button>
            <div class="cartbox__inner text-left">
                <div v-if="listproductNew && isStoreOpen">
                    <div class="cartbox__items">
                        <div v-for="(listproduct, index) in listproductNew.items">
                            <div class="cartbox__item">
                                <div class="cartbox__item__thumb">
                                    <img v-bind:src="listproduct.url_image" alt="small thumbnail" class="img-rounded img-cartbox-item">
                                </div>
                                <div class="cartbox__item__content">
                                    <h5 class="cartbox__item__name">{{listproduct.item.name}}</h5>
                                    <div class="cartbox__item__editbox">
                                        <button class="btn cartbox__item__edit" @click="minusItemCart('product', listproduct.item.id)" :disabled="listproduct.qty == 1"><i class="fa fa-minus-square"></i></button>
                                        <div class="cartbox__item__qty">{{listproduct.qty}}</div>
                                        <button class="btn cartbox__item__edit" @click="addItemCart('product', listproduct.item.id)"><i class="fa fa-plus-square"></i></button>
                                    </div>
                                    <p v-if="listproduct.observation"><strong>Obs: </strong>{{listproduct.observation}}</p>
                                    <span class="price">R$ {{formatPrice(listproduct.price)}}</span>
                                </div>
                                <button class="btn cartbox__item__remove" @click="deleteItemCart('product', listproduct.item.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="cartbox__total">
                        <ul>
                            <li><span class="cartbox__total__title">Quantidade total</span><span class="price">{{listproductNew.totalQty}}</span></li>
                            <li v-if="listproductNew.subTotalPrice !== listproductNew.totalPrice"><span class="cartbox__total__title">Valor subtotal</span><span class="price">R$ {{formatPrice(listproductNew.subTotalPrice)}}</span></li>
                            <li v-if="listproductNew.shipping > 0"><span class="cartbox__total__title">Valor da entrega</span><span class="price">R$ {{formatPrice(listproductNew.shipping)}}</span></li>
                            <li v-if="listproductNew.percDiscount > 0"><span class="cartbox__total__title">Desconto %</span><span class="price">{{listproductNew.percDiscount}} %</span></li>
                            <li class="grandtotal">Valor total<span class="price">R$ {{formatPrice(listproductNew.totalPrice)}}</span></li>
                        </ul>
                    </div>
                    <div class="cartbox__buttons">
                        <button id="idcheckout-cart" class="container btn btn-danger" @click="checkOut"><span>Finalizar pedido</span></button>
                    </div>
                </div>
                <div v-else>
                    <h5 v-if="isStoreOpen">Carrinho vazio</h5>
                    <h5 v-else>Loja está fechada</h5>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import config from '@/utils/config';
    let spanMiniCartQnt = $('#id-mini-cart-qnt'),
        bodyOverLay = $('.body-overlay');
    export default {
        props: ['listproduct'],
        data() {
            return {
                appUrl: config.APP_URL,
                appUrlDashboard: config.APP_URL_DASHBOARD,
                isStoreOpen : false,
                listproductNew: this.listproduct,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },
        methods: {
            async getStoreOpen(){
                const  response = await axios.get(this.appUrlDashboard+'/api/store/delivery/status/2');
                if(response.status == 200){
                    if(response.data.success){
                        this.isStoreOpen = response.data.isStoreOpen;
                    } else {
                        console.error(response.data.message);
                    }
                } else {
                    console.error('Erro ao buscar status da loja');
                }
            },
            formatPrice(value) {
                let val = (value / 1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            deleteItemCart(object, idItem){
                axios.post( this.appUrl+'/carrinho/deletar-item', {
                    product_object : object,
                    product_id: idItem
                }).then(response => {
                    if(response.data.success === true){
                        this.listproductNew = response.data.cartProduct;
                        if(!this.listproductNew){
                            spanMiniCartQnt.text('0');
                        } else {
                            spanMiniCartQnt.text(this.listproductNew.totalQty)
                        }
                    } else {
                        alert('Erro ao deletar item do carrinho');
                    }
                }).catch(error => {
                    alert('Erro ao deletar item do carrinho');
                });
            },
            addItemCart(object, idItem){
                axios.post( this.appUrl+'/carrinho/editar-item', {
                    product_object : object,
                    product_id: idItem,
                    product_operator: 'plus'
                }).then(response => {
                    if(response.data.success === true){
                        this.listproductNew = response.data.cartProduct;
                        if(!this.listproductNew){
                            spanMiniCartQnt.text('0');
                        } else {
                            spanMiniCartQnt.text(this.listproductNew.totalQty)
                        }
                    } else {
                        alert('Erro ao deletar item do carrinho');
                    }
                }).catch(error => {
                    alert('Erro ao deletar item do carrinho');
                });
            },
            minusItemCart(object, idItem){
                axios.post( this.appUrl+'/carrinho/editar-item', {
                    product_object : object,
                    product_id: idItem,
                    product_operator: 'minus'
                }).then(response => {
                    if(response.data.success === true){
                        this.listproductNew = response.data.cartProduct;
                        if(!this.listproductNew){
                            spanMiniCartQnt.text('0');
                        } else {
                            spanMiniCartQnt.text(this.listproductNew.totalQty)
                        }
                    } else {
                        alert('Erro ao deletar item do carrinho');
                    }
                }).catch(error => {
                    alert('Erro ao deletar item do carrinho');
                });
            },
            checkOut(){
                window.location.href = this.appUrl+'/pedido/finalizar';
            }
        },
        mounted() {
            this.getStoreOpen();
        }
    }
</script>
<style>
</style>
