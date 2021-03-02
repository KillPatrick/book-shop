<template>
    <div>
        <h5 class="mt-4 mb-2">Users reviews</h5>
        <div v-for="review in reviews" class="card shadow-sm bg-white rounded-lg mb-3">
            <div class="card-body p-0">
                <div class="card-header">
                    <h5>{{ review.title }}</h5>
                    <hr />
                    <p>
                                <span v-for="i in 10" :class="{'text-warning rating-star' : i <= review.rating,
                                                                'rating-star' : i > review.rating}">
                                    &#9733;
                                </span>
                    </p>
                </div>
                <p class="card-text p-2">
                    {{ review.review }}
                </p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['book_id'],
    data(){
        return {
            reviews: []
        }
    },
    mounted() {
        console.log(this.props);
        axios.get('/api/v1/reviews?book_id='+this.book_id).then(response => {
            this.reviews = response.data.data;
        });
    }
}
</script>
