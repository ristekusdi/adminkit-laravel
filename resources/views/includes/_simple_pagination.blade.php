<ul class="pagination">
    @if (empty($first))
        <li class="page-item disabled">
            <a class="page-link">{!! __('pagination.previous') !!}</a>
        </li>
    @else
        <li class="page-item">
            <a class="page-link" wire:click="previousPage" wire:key="previous">{!! __('pagination.previous') !!}</a>
        </li>
    @endif

    @if (count($items) < $perPage)
        <li class="page-item disabled">
            <a class="page-link">{!! __('pagination.next') !!}</a>
        </li>
    @else
        <li class="page-item">
            <a class="page-link" wire:click="nextPage" wire:key="next">{!! __('pagination.next') !!}</a>
        </li>
    @endif
</ul>