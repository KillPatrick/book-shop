<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm bg-white rounded-lg">
                    <h4 class="sticky-top position-absolute ml-2 mt-1">
                        <span v-if="book.rating" class="badge badge-success shadow-sm">-{{ book.rating }}%</span>
                        <span class="badge badge-secondary shadow-sm">{{ book.price }} &euro;</span>
                        <span v-if="book.new" class="badge badge-warning shadow-sm">New</span>
                    </h4>
                    <img class="mx-auto pt-5" v-bind:src="'/' + book.image" :title="book.title" width="50%" />
                    <div class="card-body p-2">
                        <p class="card-text">

                        <b>{{ book.title }}</b>
                        </p>
                    </div>
                    <div class="card-footer p-3">
                        <span v-for="i in 10" :class="{'text-warning rating-star' : i <= book.rating,
                                                                'rating-star' : i > book.rating}">
                            &#9733;
                        </span>
                        <hr />
                        {{ book.genres }}
                        <hr />
                        {{ book.authors }}
                        <hr />

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="mb-2">Description</h5>
                <div class="card shadow-sm bg-white rounded-lg">
                    <div class="card-body p-0">
                        <p class="card-text p-2">
                            {{ book.description }}
                        </p>
                    </div>
                </div>
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
        </div>
    </div>
</template>
<script>
    export default {
        props: ['book_id'],
        data(){
            return {
                book: [],
                reviews: []
            }
        },
        mounted() {
            axios.get('/api/v1/books/'+this.book_id).then(response => {
                this.book = response.data.data;
            });
            axios.get('/api/v1/reviews?book_id='+this.book_id).then(response => {
                this.reviews = response.data.data;
            });
        }
    }
</script>
