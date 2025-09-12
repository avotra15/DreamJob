import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';

@Component({
  selector: 'roles-management',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule, ReactiveFormsModule],
  templateUrl: './roles-management.component.html',
})
export class RolesManagementComponent {

  rolesList: any[] = [];
  permisionList: any[] = [];
  userId!: number;
  selectedRoleId!: number;
  selectedRole: string = '';

  constructor(private http: HttpClient, private router: Router, private route: ActivatedRoute) {}

  ngOnInit(): void {
    const idParam = this.route.snapshot.paramMap.get('id');
    if (idParam) {
      this.userId = +idParam;
      this.loadUserRole(this.userId);
    }
    this.loadRoles();
    this.loadPermission();
  }

  loadUserRole(id: number): void {
      const token = sessionStorage.getItem('token');

      const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });
    this.http.get<any>(`http://127.0.0.1:8000/user/${id}`, { headers })
      .subscribe({
        next: res => {
          if (res.role) {
            this.selectedRoleId = res.role.id;
            this.selectedRole = res.role.name;
          }
        },
        error: err => console.error('Erreur chargement rôle:', err)
      });
  }

  loadRoles(): void {
      const token = sessionStorage.getItem('token');

      const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });

    this.http.get<any[]>('http://127.0.0.1:8000/roles', { headers })
      .subscribe({
        next: (response) => {
          this.rolesList = Array.isArray(response) ? response : response ?? [];
        },
          error: (err) => {
            console.error('Erreur lors du chargement des users:', err);
            this.rolesList = [];
          }
      });
  }

    loadPermission(): void {
      const token = sessionStorage.getItem('token');

      const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });

    this.http.get<any>('http://127.0.0.1:8000/permissions', { headers })
      .subscribe({
        next: (res) => {
        const list = Array.isArray(res.data) ? res.data : [];
            this.permisionList = list.map((p: any) => ({ ...p, checked: false }));
        },
          error: (err) => {
            console.error('Erreur lors du chargement des users:', err);
            this.permisionList = [];
          }
      });
  }
/*
      saveSelectedPermissions(): void {
      const selected = this.permisionList
        .filter(p => p.checked)
        .map(p => p.idPerm);

      console.log('IDs cochés :', selected);
  }
*/
}
