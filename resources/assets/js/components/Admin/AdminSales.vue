<template>
    <div>
        <div>
            <table class="table table-sm mt-4">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sale ID</th>
                        <th>Merchant</th>
                        <th>Merchant Order ID</th>
                        <th>Program</th>
                        <th>Order Total</th>
                        <th>Affiliate</th>
                        <th>Affiliate Reward</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sale in sales">
                        <td>{{sale.created_at}}</td>
                        <td>{{sale.id}}</td> 
                        <td>{{sale.subscription.program.merchant.name}}</td> 
                        <td>{{sale.order_id}}</td> 
                        <td>{{sale.subscription.program.name}}</td> 
                        <td>{{sale.order_total}}</td> 
                        <td>{{sale.subscription.user.full_name}}</td> 
                        <td>{{sale.reward.amount_gbp}}</td> 
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ['sales'],
    data(){
        return {
        }
    },
}
</script>
