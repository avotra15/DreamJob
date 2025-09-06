import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
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
  }

  loadUserRole(id: number): void {
    this.http.get<any>(`http://127.0.0.1:8000/user/${id}`)
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
    this.http.get<any[]>('http://127.0.0.1:8000/roles')
      .subscribe({
        next: (response) => {
          this.rolesList = Array.isArray(response) ? response : response ?? [];
        },
        error: (err) => console.error('Erreur lors du chargement des rôles:', err)
      });
  }
}
