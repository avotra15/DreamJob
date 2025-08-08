import { CommonModule } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-post-job',
  imports: [FormsModule, RouterModule, CommonModule],
  templateUrl: './post-job.component.html'
})
export class PostJobComponent {
  fichierFile?: File;
  onFileSelected(event: Event) {
  const input = event.target as HTMLInputElement;
  if (!input.files || input.files.length === 0) {
    this.fichierFile = undefined;
    return;
  }
  this.fichierFile = input.files[0]
}
  titre: string = '';
  description: string = '';
  logoFile?: File;
  onLogoSelected(event: Event) {
    const input = event.target as HTMLInputElement;
      if (!input.files || input.files.length === 0) {
      this.logoFile = undefined;
      return;
    }
    this.logoFile = input.files[0];
}

  constructor(private http:HttpClient, private router: Router) {}

   onSubmit(): void {
      const token = sessionStorage.getItem('token');

      const formData = new FormData();
      if (this.fichierFile) {
        formData.append('fichierFile', this.fichierFile);
      }
      formData.append('titre', this.titre);
      formData.append('description', this.description);
      if (this.logoFile) {
        formData.append('logoFile', this.logoFile);
      }

       const headers = new HttpHeaders({ 'Authorization': `Bearer ${token}` });


           this.http.post<any[]>('http://127.0.0.1:8000/api/newjob', formData, { headers })
           
              .subscribe({
              next: res => {
                console.log("Job enregistrer avec success", res);
                this.router.navigate(['/job-listings']);
              },
              error: err => {
                console.error("failed enregistrer du Job:", err);
      }
    })
    }
}
