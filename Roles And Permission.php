 ************************************************* Roles And Permission **************************************************

 In User Table Column 
 id                      bigint     20       Auto Increment
 name                    varchar    220 
 contact                 varchar    220 
 email                   varchar    220
 image                   varchar    220 
 role                    enum       121,1,2,3,4 
 created_at              timestamp  
 updated_at              timestamp  



 In Permission Table Column
 id                      bigint     20       Auto Increment
 user_role_id            varchar    220 
 name                    varchar    220 
 description             varchar    220 
 created_at              timestamp  
 updated_at              timestamp  


 Route::controller(RoleController::class)->middleware('auth')->group(function (){
    Route::match(['get', 'post'], '/role', 'role')->name('role');  
    Route::get('assign-role/{id}', 'assignRoles')->name('assignRoles');  
    Route::post('assign-roles', 'assignRolesSaved')->name('assignRolesSaved');
});




class RoleController extends Controller
{
    public function role(Request $req){
        if($req->isMethod('get')){
            $uniqueRoles = User::select('role')->distinct()->pluck('role');
            return view('admin.role.index', compact('uniqueRoles'));
        }
    }

    public function assignRoles($id){
        $auth = Auth::User();
        // dd($auth->id);
        $user = User::find($auth->id);
        $userPermissions = Permission::where('user_role_id', $id)->pluck('name')->toArray();
        // dd($userPermissions);
        return view('admin.role.assign-role', compact('id','userPermissions'));
    }

    public function assignRolesSaved(Request $req){
        // dd($req->all());
        try{
            $req->validate([
                'user_role_id' => 'required',
                'permissions' => 'nullable|array',
            ]);

            if($req->has('permissions')) {
                foreach($req->permissions as $permission) {
                    $data = [
                        'name' => $permission,
                        'user_role_id' => $req->user_role_id,
                    ];
                    Permission::create($data);
                }
            }
            return redirect('role')->with('success','Permission Add Successfully!');

        }catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();        
        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());        
        }
        


    
    }
}









**************************************** admin.role.index.blade.php ****************************************************
<div class="card shadow-card" onload="reloadPage()">
    <div class="card-body">
        <table class="table table-striped" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Role</th>                  
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($uniqueRoles as $data)
                <tr>
                   <td>{{ $loop->iteration }}</td>                   
                   <td>
                        @if($data == 121)
                            {{ 'Admin' }}
                            @elseif($data == 1)
                             {{ 'Owner' }}
                             @elseif($data == 2)
                                 {{ 'Supervisior' }}
                                 @elseif($data == '3')
                                 {{ 'Manager' }}
                                   @elseif($data == '4')
                                    {{ 'Account Manager' }}
                                    @else
                                     {{ 'Not Provided' }}
                            @endif
                    </td>                
                        
                   <td style="d-flex" >
                        <a href="{{ route('assignRoles', $data) }}" class="btn btn-success btn-sm" >Edit Roles</a>

                   </td>
                    
                </tr>    
                


                
                 
                @endforeach
            </tbody>
        </table>
    </div>
</div>




**************************************** admin.role.assign-role.blade.php ****************************************************
<div class="card shadow-card" onload="reloadPage()">
     

	<div class="card-body">
		<form action="{{ route('assignRolesSaved') }}" method="post">
			@csrf
			<input type="hidden" name="user_role_id" value="{{ $id }}" >
			<div class="row">
				
				<div class="col-md-4">
					<p class="user-heading">Account Management</p>
				</div>
				<div class="col-md-4 card-column">
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input select-all" id="AccountMngSelectAll" data-group="account-management">
						<label class="form-check-label" for="AccountMngSelectAll">Select All</label>
					</div>
				</div>
				<div class="col-md-4 card-column">
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input account-management" id="AccountMngListing" name="permissions[]" value="AccountMngListing" {{ in_array('AccountMngListing', $userPermissions) ? 'checked' : '' }}>
						<label class="form-check-label" for="AccountMngListing">Listing</label>
					</div>
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input account-management" id="AccountMngRole" name="permissions[]" value="AccountMngRole" {{ in_array('AccountMngRole', $userPermissions) ? 'checked' : '' }}>
						<label class="form-check-label" for="AccountMngRole">Role</label>
					</div>
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input account-management" id="editCheckbox" name="permissions[]" value="edit" {{ in_array('edit', $userPermissions) ? 'checked' : '' }}>
						<label class="form-check-label" for="editCheckbox">User Edit</label>
					</div>
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input account-management" id="deleteCheckbox" name="permissions[]" value="delete" {{ in_array('delete', $userPermissions) ? 'checked' : '' }}>
						<label class="form-check-label" for="deleteCheckbox">User Delete</label>
					</div>
				</div>
	
				<div class="col-md-4">
					<p class="user-heading">Product</p>
				</div>
				<div class="col-md-4 card-column">
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input select-all" id="ProductSelectAll" data-group="product">
						<label class="form-check-label" for="ProductSelectAll">Select All</label>
					</div>
				</div>
				<div class="col-md-4 card-column">
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input product" id="addProductCheckbox" name="permissions[]" value="addProduct" {{ in_array('addProduct', $userPermissions) ? 'checked' : '' }}>
						<label class="form-check-label" for="addProductCheckbox">Add Product</label>
					</div>
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input product" id="productListCheckbox" name="permissions[]" value="productList" {{ in_array('productList', $userPermissions) ? 'checked' : '' }}>
						<label class="form-check-label" for="productListCheckbox">Product List</label>
					</div>
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input product" id="productRejectCheckbox" name="permissions[]" value="productReject" {{ in_array('productReject', $userPermissions) ? 'checked' : '' }}>
						<label class="form-check-label" for="productRejectCheckbox">Reject Product</label>
					</div>
				</div>
	
				<div class="col-md-4">
					<input type="submit" value="Submit" class="btn btn-success">
				</div>
	
			</div>
		</form>
	</div>
	

</div>

@push('js')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.select-all').forEach(function (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                const group = this.dataset.group;
                const checkboxes = document.querySelectorAll(`.${group}`);
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });

        document.querySelectorAll('.form-check-input:not(.select-all)').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const group = this.classList[1];
                const selectAllCheckbox = document.querySelector(`.select-all[data-group=${group}]`);
                const checkboxes = document.querySelectorAll(`.${group}`);
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
            });
        });
    });
</script>




