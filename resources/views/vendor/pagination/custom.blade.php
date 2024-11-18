@if ($paginator->hasPages())
    <ul class="pagination custom-pagination">
        {{-- Botón "Anterior" --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link"><i class="fas fa-chevron-left"></i> Anterior</span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">
                    <i class="fas fa-chevron-left"></i> Anterior
                </a>
            </li>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botón "Siguiente" --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">
                    Siguiente <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Siguiente <i class="fas fa-chevron-right"></i></span>
            </li>
        @endif
    </ul>
@endif
