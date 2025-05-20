<x-app-layout>
    <div class="container">
        <h2>Editar Usuario</h2>

        <form action="{{ route('admin.user.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="status">Estado</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Activo</option>
                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
