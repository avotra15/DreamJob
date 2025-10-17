import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { PageService } from '../../services/PageService';

@Component({
  selector: 'permission-access',
  imports: [CommonModule, FormsModule, RouterModule, ReactiveFormsModule],
  templateUrl: './permission-access.html',
  styleUrl: './permission-access.scss'
})
export class PermissionAccessComponent {
  rolesList: any[] = [];
  pagesList: any[] = [];

  constructor(private http: HttpClient, private router: Router, private route: ActivatedRoute, private pageService: PageService) {}

  ngOnInit(): void {
    this.loadRoles();
    this.loadPages();
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

    loadPages(): void {
      const token = sessionStorage.getItem('token');

      const headers = new HttpHeaders({ 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` });

    this.http.get<any>('http://127.0.0.1:8000/pages', { headers })
      .subscribe({
        next: (res) => {      
          const pages = res.data || [];
            const list = Array.isArray(pages) ? pages : Object.values(pages);
            //const list = Array.isArray(res) ? res : res ?? [];
              this.pagesList = list.map((pg: any) => ({ 
                ...pg, 
                roles: pg.roles ?? [],
                checked: false 
              }));
        },
          error: (err) => {
            console.error('Erreur lors du chargement des users:', err);
            this.pagesList = [];
          }
      });
  }

      // Vérifie si une page a un rôle spécifique
    isPageRoleChecked(page: any, roleId: number): boolean {
      return page.roles.some((role: any) => role.idRole === roleId || role.id === roleId);
    }

    // Gère le changement de checkbox
    onCheckboxChange(event: any, nom: string, id: number) {
      const isChecked = event.target.checked;
  
      this.pageService.updateDroitPage(nom, id, isChecked).subscribe({
        next: (res) => {
          console.log('Permission mise à jour avec succès');
          // Recharger les pages pour mettre à jour l'affichage
          this.loadPages();
        },
        error: (err) => {
          console.error('Erreur mise à jour permission:', err);
          // Revenir à l'état précédent en cas d'erreur
          event.target.checked = !isChecked;
        }
      });

    }
}
