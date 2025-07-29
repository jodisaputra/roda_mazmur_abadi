<?php

namespace App\Services;

use App\Models\Category;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Html\Column;

class CategoryDataTableService
{
    /**
     * Get DataTable data for categories
     */
    public function getDataTable()
    {
        $categories = Category::with('parent')->select('categories.*');

        return DataTables::of($categories)
            ->addIndexColumn() // Untuk DT_RowIndex
            ->addColumn('icon', function ($category) {
                if ($category->image) {
                    $imageUrl = asset('storage/' . $category->image);
                    return '<img src="' . $imageUrl . '" alt="' . $category->name . '" class="img-thumbnail" style="width: 40px; height: 40px; object-fit: cover;" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'inline\';">
                           <i class="bi bi-folder fs-4 text-muted" style="display: none;"></i>';
                } else {
                    return '<i class="bi bi-folder fs-4 text-muted"></i>';
                }
            })
            ->addColumn('name', function ($category) {
                $html = '<div class="d-flex align-items-center">';
                $html .= '<div>';
                $html .= '<h6 class="mb-0">' . $category->name . '</h6>';
                if ($category->parent) {
                    $html .= '<small class="text-muted">Parent: ' . $category->parent->name . '</small>';
                }
                $html .= '</div>';
                $html .= '</div>';
                return $html;
            })
            ->addColumn('status', function ($category) {
                $badgeClass = $category->status === 'active' ? 'bg-success' : 'bg-danger';
                $statusText = ucfirst($category->status);
                return '<span class="badge ' . $badgeClass . '">' . $statusText . '</span>';
            })
            ->addColumn('products_count', function ($category) {
                return $category->products()->count();
            })
            ->addColumn('actions', function ($category) {
                return '
                    <div class="dropdown">
                        <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('admin.categories.edit', $category->id) . '">
                                <i class="bi bi-pencil me-2"></i>Edit
                            </a></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteCategory(' . $category->id . ')">
                                <i class="bi bi-trash me-2"></i>Delete
                            </a></li>
                        </ul>
                    </div>
                ';
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where('categories.name', 'like', '%'.$keyword.'%')
                      ->orWhereHas('parent', function($q) use ($keyword) {
                          $q->where('name', 'like', '%'.$keyword.'%');
                      });
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('categories.status', 'like', '%'.$keyword.'%');
            })
            ->rawColumns(['icon', 'name', 'status', 'actions'])
            ->make(true);
    }    /**
     * Get HTML builder for DataTable
     */
    public function getHtmlBuilder(): Builder
    {
        return app(Builder::class)
            ->setTableId('categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax(route('admin.categories.index'))
            ->dom('<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip')
            ->orderBy(1, 'asc') // Order by name column (index berubah karena tidak ada checkbox)
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'searching' => true,
                'language' => [
                    'search' => '',
                    'searchPlaceholder' => 'Search categories...',
                    'lengthMenu' => 'Show _MENU_ entries',
                    'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                    'infoEmpty' => 'Showing 0 to 0 of 0 entries',
                    'infoFiltered' => '(filtered from _MAX_ total entries)',
                ],
                'pageLength' => 10,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, 'All']],
                'columnDefs' => [
                    ['orderable' => false, 'targets' => [0, 4]], // Disable ordering for number and actions
                    ['searchable' => false, 'targets' => [0, 4]], // Disable search for number and actions
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
            Column::make('icon')
                ->title('Icon')
                ->searchable(false)
                ->orderable(false)
                ->width(60),
            Column::make('name')
                ->title('Name')
                ->searchable(true)
                ->orderable(true),
            Column::make('products_count')
                ->title('Products')
                ->searchable(false)
                ->orderable(true)
                ->width(80),
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
