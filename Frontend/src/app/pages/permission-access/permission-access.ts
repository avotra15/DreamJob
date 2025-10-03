import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { PermissionService } from '../../services/permission.service';

@Component({
  selector: 'permission-access',
  imports: [CommonModule, FormsModule, RouterModule, ReactiveFormsModule],
  templateUrl: './permission-access.html',
  styleUrl: './permission-access.scss'
})
export class PermissionAccessComponent {
  rolesList: any[] = [];
  permisionList: any[] = [];

  constructor(private http: HttpClient, private router: Router, private route: ActivatedRoute, private permissionService: PermissionService) {}

  ngOnInit(): void {
    this.loadRoles();
    this.loadPermission();
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

    this.http.get<any>('http://127.0.0.1:8000/voirpermission', { headers })
      .subscribe({
        next: (res) => {      
          const permissions = res.data || [];
            const list = Array.isArray(permissions) ? permissions : Object.values(permissions);
              this.permisionList = list.map((p: any) => ({ 
                ...p, 
                roles: p.roles ?? [],
                checked: false 
              }));
        },
          error: (err) => {
            console.error('Erreur lors du chargement des users:', err);
            this.permisionList = [];
          }
      });
  }

  // Vérifier si une permission est assignée à un rôle
  isPermissionAssigned(permission: any, idRole: number): boolean {
    if (!permission || !permission.roles) return false;
    return permission.roles.some((role: any) => role.id === idRole);
  }
  togglePermission(idPerm: number, idRole: number, event: any): void {
      const isChecked = event.target.checked;
      this.permissionService.updatePermissionRole(idPerm, idRole, isChecked)
  }
}
