<?php

namespace App\Services;

use App\Models\Product;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class ProductDataTableService
{
    /**
     * Get DataTable data for products
     */
    public function getDataTable()
    {
        $products = Product::with(['category', 'primaryImage'])->select('products.*');

        return DataTables::of($products)
            ->addIndexColumn() // Untuk DT_RowIndex
            ->addColumn('image', function ($product) {
                $imageUrl = $product->primary_image_url;
                return '<img src="' . $imageUrl . '" alt="' . $product->name . '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">';
            })
            ->addColumn('name', function ($product) {
                $html = '<div class="d-flex align-items-center">';
                $html .= '<div>';
                $html .= '<h6 class="mb-0">' . $product->name . '</h6>';
                if ($product->category) {
                    $html .= '<small class="text-muted">Category: ' . $product->category->name . '</small>';
                }
                if ($product->sku) {
                    $html .= '<br><small class="text-muted">SKU: ' . $product->sku . '</small>';
                }
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('price', function ($product) {
                return $product->formatted_price;
            })
            ->addColumn('stock', function ($product) {
                $stockClass = $product->stock_quantity > 10 ? 'text-success' : ($product->stock_quantity > 0 ? 'text-warning' : 'text-danger');
                $stockText = $product->stock_quantity . ' units';

                $html = '<span class="' . $stockClass . '">' . $stockText . '</span>';

                if (!$product->in_stock) {
                    $html .= '<br><span class="badge bg-danger">Out of Stock</span>';
                } else {
                    $html .= '<br><span class="badge bg-success">In Stock</span>';
                }

                return $html;
            })
            ->addColumn('status', function ($product) {
                $badgeClass = match($product->status) {
                    'active' => 'bg-success',
                    'draft' => 'bg-warning',
                    'inactive' => 'bg-danger',
                    default => 'bg-secondary'
                };
                $statusText = ucfirst($product->status);
                return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
            })
            ->addColumn('actions', function ($product) {
                return '
                    <div class="dropdown">
                        <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('admin.products.show', $product->id) . '">
                                <i class="bi bi-eye me-2"></i>View
                            </a></li>
                            <li><a class="dropdown-item" href="' . route('admin.products.edit', $product->id) . '">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="toggleStatus(' . $product->id . ')">
                                <i class="bi bi-toggle-' . ($product->status === 'active' ? 'off' : 'on') . ' me-2"></i>' .
                                ($product->status === 'active' ? 'Deactivate' : 'Activate') . '
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="toggleStock(' . $product->id . ')">
                                <i class="bi bi-box me-2"></i>' .
                                ($product->in_stock ? 'Mark Out of Stock' : 'Mark In Stock') . '
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteProduct(' . $product->id . ')">
                                <i class="bi bi-trash me-2"></i>Delete
                            </a></li>
                        </ul>
                    </div>
                ';
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where('products.name', 'like', '%'.$keyword.'%')
                      ->orWhere('products.sku', 'like', '%'.$keyword.'%')
                      ->orWhereHas('category', function($q) use ($keyword) {
                          $q->where('name', 'like', '%'.$keyword.'%');
                      });
            })
            ->filterColumn('price', function($query, $keyword) {
                // Remove currency formatting for search
                $numericKeyword = preg_replace('/[^0-9]/', '', $keyword);
                if ($numericKeyword) {
                    $query->where('products.price', 'like', '%'.$numericKeyword.'%');
                }
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('products.status', 'like', '%'.$keyword.'%');
            })
            ->rawColumns(['image', 'name', 'stock', 'status', 'actions'])
            ->make(true);
    }

    /**
     * Get HTML builder for DataTable
     */
    public function getHtmlBuilder(): Builder
    {
        return app(Builder::class)
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('admin.products.index'))
            ->dom('<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip')
            ->orderBy(1, 'asc') // Order by name column
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'searching' => true,
                'language' => [
                    'search' => '',
                    'searchPlaceholder' => 'Search products...',
                    'lengthMenu' => 'Show _MENU_ entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'infoEmpty' => 'Showing 0 to 0 of 0 entries',
                    'infoFiltered' => '(filtered from _MAX_ total entries)',
                ],
                'pageLength' => 10,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, 'All']],
                'columnDefs' => [
                    ['orderable' => false, 'targets' => [0, 1, 6]], // Disable ordering for number, image, and actions
                    ['searchable' => false, 'targets' => [0, 1, 6]], // Disable search for number, image, and actions
                ],
            ]);
    }

    /**
     * Get columns for DataTable
     */
    protected function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No.')
                ->searchable(false)
                ->orderable(false)
                ->width(50),
            Column::make('image')
                ->title('Image')
                ->searchable(false)
                ->orderable(false)
                ->width(80),
            Column::make('name')
                ->title('Product')
                ->searchable(true)
                ->orderable(true),
            Column::make('price')
                ->title('Price')
                ->searchable(true)
                ->orderable(true)
                ->width(120),
            Column::make('stock')
                ->title('Stock')
                ->searchable(false)
                ->orderable(true)
                ->width(120),
            Column::make('status')
                ->title('Status')
                ->searchable(true)
                ->orderable(true)
                ->width(100),
            Column::make('actions')
                ->title('')
                ->searchable(false)
                ->orderable(false)
                ->width(60),
        ];
    }
}
