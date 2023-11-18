<!-- _sidebar.blade.php -->

<aside class="sidebar">
    <ul>
        <li><a href="/transactions">{{__('List Transactions')}}</a></li>
        @can('create', \App\Models\Transaction::class)
        <li><a href="/transactions/create">{{__('Create New Transaction')}}</a></li>
        @endcan

    </ul>
</aside>
