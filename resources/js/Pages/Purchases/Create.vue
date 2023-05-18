<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import { onMounted, reactive, ref, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { getToday } from '@/common';


  const props = defineProps({
    'customers' : Array,
    'items' : Array,
    errors : Object
})

const form = reactive({
    date: null,
    customer_id: null,
    status: true,
    items: []
  })

  const itemList = ref([])

 const totalPrice = computed(()=>{
    let total = 0
    itemList.value.forEach( item =>{
        total +=item.price * item.quantity
    })
    return total
})

const storePurchase = () => {
    itemList.value.forEach( item => {
        if( item.quantity > 0) {
            form.items.push({
                id: item.id,
                quantity: item.quantity
            })
        }
    })
    Inertia.post(route('purchases.store'),form)
}

const quantity = ["0","1","2","3","4","5","6","7","8","9"]

</script>



<template>
    <Head title="購入画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購入画面
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <section class="text-gray-600 body-font relative">

                         <BreezeValidationErrors :errors="errors" />

                         <form @submit.prevent="storePurchase">   
                        <div class="container px-5 py-3 mx-auto">
                            <div class="lg:w-1/2 md:w-2/3 mx-auto">
                            <div class="flex flex-wrap -m-2">

                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex frex-wrap -m-2">
                    
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                                <input type="date" id="date" name="date" v-model="form.date" class="w-full bg-gray-100 bg-opacity-50 rouded boder border-gray-300 focus:border-indigo-500 focus: bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <div v-if="errors.date"> {{ errors.date }} </div>   
                                            </div>
                                        </div>

                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="customer" class="leading-7 text-sm text-gray-600">会員名</label>
                                                 <select  name="customer" v-model="form.customer_id" class="w-full bg-gray-100 bg-opacity-50 rouded boder border-gray-300 focus:border-indigo-500 focus: bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <option v-for="customer in customers" :value="customer.id" :key="customer.id">
                                                       {{ customer.id }} : {{ customer.name }}
                                                    </option>                                                   
                                                 </select>
                                                 <div v-if="errors.name">{{ errors.name }} </div> 
                                              </div>
                                        </div>




                                    <div class="p-2 w-full">
                                         <button class="flex mx-auto text-white bg-indigo-500 border-0 py px-8 focus:ouyline-none hover:bg-indigo-600 rounded text-lg">
                                          登録
                                         </button> 
                                    </div> 

                                    </div>
                                </div>                                   
                            </div>
                            </div>
                        </div>
                        </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>