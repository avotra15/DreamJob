import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
    export class PageService {

      constructor(private http:HttpClient) { }

        updateDroitPage(nompage: string , idRole: number, isChecked: Boolean){
              const token = sessionStorage.getItem('token');
              const headers = new HttpHeaders({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
        });
              const body = {
                nom_page: nompage,
                role_id: idRole,
                action: isChecked,
              } 

              return this.http.post('http://127.0.0.1:8000/pages/checked', body, { headers });
        }
    }
