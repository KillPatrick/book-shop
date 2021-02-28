import ReviewsIndex from '../components/Review/Index.vue'

export default {
    mode: 'history',
    routes: [
        {
            path: '/reviews/v1/?book_id=:book_id',
            component: ReviewsIndex,
            name: 'reviews.index'
        },
    ]
}
