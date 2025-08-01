import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-edit',
  standalone: true,
  imports: [FormsModule, RouterModule, CommonModule],
  templateUrl: './edit.component.html',
})
export class EditComponent implements OnInit {

  newnm: string = '';
  newmail: string = '';
  // newrls: string = '';
  newmdp: string = '';

  id: number = 0;

  constructor(
    private http: HttpClient,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.id = Number(this.route.snapshot.paramMap.get('id'));
    this.loadUser();
  }

  loadUser(): void {
    const token = sessionStorage.getItem('token');
    const headers = new HttpHeaders({ 'Authorization': `Bearer ${token}` });

    this.http.get<any>(`http://127.0.0.1:8000/api/user/${this.id}`, { headers })
      .subscribe({
        next: data => {
          this.newnm = data.user.nom;
          this.newmail = data.user.email;
          this.newmdp = data.user.mdp;
        },
        error: err => console.error("Erreur lors du chargement de l'utilisateur :", err)
      });
  }

  onSubmit(): void {
    const updateData = {
      Nom: this.newnm,
      Email: this.newmail,
      Password: this.newmdp
    };

    const token = sessionStorage.getItem('token');
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });

    this.http.patch(`http://127.0.0.1:8000/api/update/${this.id}`, updateData, { headers })
      .subscribe({
        next: res => {
          console.log("Utilisateur modifié avec succès", res);
          this.router.navigate(['/users']);
        },
        error: err => {
          console.error("Erreur lors de la mise à jour :", err);
        }
      });
  }
}
