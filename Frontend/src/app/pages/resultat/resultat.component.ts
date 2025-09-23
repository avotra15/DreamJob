import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';

@Component({
  selector: 'app-resultat',
  imports: [CommonModule],
  templateUrl: './resultat.component.html',
  //styleUrl: './resultat.component.scss'
})
export class ResultatComponent {
  permisionList: any[] = [];
  rolesList: any[] = [];

  constructor (private http:HttpClient) {}

  ngOnInit(): void {
    this.loadPermission();
  }

  loadPermission() {
      const token = sessionStorage.getItem('token');

      const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });

       this.http.get<any>('http://127.0.0.1:8000/voirpermission', { headers })
      .subscribe({
        next: (res) => {
          const permissions = res.data || [];
          this.permisionList = (Array.isArray(permissions) ? permissions : Object.values(permissions))
            .map((p: any) => ({
              idPerm: p.idPerm,
              description: p.description,
              roles: p.roles || [] // ex: ["ROLE_ADMIN"]
            }));
        },
        error: (err) => {
          console.error('Erreur lors du chargement des permissions:', err);
          this.permisionList = [];
        }
      });
  }

    hasRole(permission: any, roleName: string): boolean {
    return permission.roles.includes(roleName);
  }
  
}
