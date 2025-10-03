import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';
import { Router, RouterModule } from '@angular/router';

interface Permission {
  idPerm: number;
  name: string;
  permissionName?: string;
  description?: string;
  roles: string[];
}

interface Role {
  id: number;
  idRole?: number;
  name: string;
  roleName?: string;
  role?: string;
}


@Component({
  selector: 'resultat',
  imports: [CommonModule, RouterModule],
  templateUrl: './resultat.component.html',
  //styleUrl: './resultat.component.scss'
})
export class ResultatComponent {
  permissionsList: any[] = [];
  rolesList: any[] = [];
  isLoading: boolean = true;

  constructor (private http:HttpClient, private router: Router) {}

  ngOnInit(): void {
      this.loadData();
  }

  loadData(): void {
    this.isLoading = true;
    Promise.all([
      this.loadRoles(),
      this.loadPermissions()
    ]).then(() => {
      this.isLoading = false;
    }).catch((error) => {
      console.error('Erreur lors du chargement des données:', error);
      this.isLoading = false;
    });
  }

  private loadRoles(): Promise<void> {
    return new Promise((resolve, reject) => {
      const token = sessionStorage.getItem('token');
      const headers = new HttpHeaders({ 
        'Content-Type': 'application/json', 
        'Authorization': `Bearer ${token}` 
      });

      this.http.get<any[]>('http://127.0.0.1:8000/roles', { headers })
        .subscribe({
          next: (response) => {
            this.rolesList = Array.isArray(response) ? response : (response ?? []);
            resolve();
          },
          error: (err) => {
            console.error('Erreur lors du chargement des rôles:', err);
            this.rolesList = [];
            reject(err);
          }
        });
    });
  }

    /**
   * Charge la liste des permissions
   */
  private loadPermissions(): Promise<void> {
    return new Promise((resolve, reject) => {
      const token = sessionStorage.getItem('token');
      const headers = new HttpHeaders({ 
        'Content-Type': 'application/json', 
        'Authorization': `Bearer ${token}` 
      });

      this.http.get<any>('http://127.0.0.1:8000/voirpermission', { headers })
        .subscribe({
          next: (res) => {
            const permissions = res.data || [];
            const list = Array.isArray(permissions) ? permissions : Object.values(permissions);
            
            this.permissionsList = list.map((p: any) => ({
              ...p,
              roles: p.roles ?? []
            }));
            resolve();
          },
          error: (err) => {
            console.error('Erreur lors du chargement des permissions:', err);
            this.permissionsList = [];
            reject(err);
          }
        });
    });
  }

  /**
   * Obtient le nom d'un rôle
   */
  getRoleName(role: Role): string {
    return role.name || role.roleName || role.role || `Role ${role.id || role.idRole}`;
  }

  /**
   * Obtient le nom d'une permission
   */
  getPermissionName(permission: Permission): string {
    return permission.name || permission.permissionName || `Permission ${permission.idPerm}`;
  }

  /**
   * Vérifie si un rôle a une permission
   */
  hasPermission(permission: Permission, roleName: string): boolean {
    return permission.roles && permission.roles.includes(roleName);
  }

  /**
   * Obtient le statut d'une permission pour un rôle
   */
  getPermissionStatus(permission: Permission, roleName: string): 'View' | 'Non' {
    return this.hasPermission(permission, roleName) ? 'View' : 'Non';
  }

  /**
   * Obtient la classe CSS pour le statut
   */
  getStatusClass(permission: Permission, roleName: string): string {
    return this.hasPermission(permission, roleName) ? 'status-granted' : 'status-denied';
  }

  /**
   * Navigue vers la page d'édition des permissions
   */
  editPermissions(): void {
    this.router.navigate(['/permission-access']);
  }

  /**
   * Exporte les permissions au format JSON
   */
  exportPermissions(): void {
    const exportData = {
      timestamp: new Date().toISOString(),
      roles: this.rolesList,
      permissions: this.permissionsList.map(perm => ({
        id: perm.idPerm,
        name: this.getPermissionName(perm),
        description: perm.description,
        roles: this.rolesList.map(role => ({
          roleName: this.getRoleName(role),
          hasPermission: this.hasPermission(perm, this.getRoleName(role)),
          status: this.getPermissionStatus(perm, this.getRoleName(role))
        }))
      }))
    };

    const dataStr = JSON.stringify(exportData, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);
    
    const link = document.createElement('a');
    link.href = url;
    link.download = `permissions_export_${new Date().toISOString().slice(0, 10)}.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
  }

  /**
   * Imprime la page
   */
  printReport(): void {
    window.print();
  }

  /**
   * Rafraîchit les données
   */
  refreshData(): void {
    this.loadData();
  }
  
}
