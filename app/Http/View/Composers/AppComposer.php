<?php


namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Book;
use Illuminate\Support\Facades\Gate;
class AppComposer
{
    public function __construct()
    {

    }

    public function compose(View $view)
    {
        if(auth()->user()){
            $items = array();

            if(Gate::allows('is-admin')){
                $items['notApprovedCount'] = Book::whereNull('is_approved')->count();
            }

            $items['userBookCount'] = auth()->user()->books()->count();

            $view->with($items);
        }
    }
}
