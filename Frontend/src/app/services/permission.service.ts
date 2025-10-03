import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
    export class PermissionService {

      constructor(private http:HttpClient) { }

        updatePermissionRole(idPerm: number , idRole: number, isChecked: Boolean){
              const token = sessionStorage.getItem('token');
              const headers = new HttpHeaders({
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
        });
              const body = {
                permission_id: idPerm,
                role_id: idRole,
                action: isChecked,
              } 

              return this.http.post('http://127.0.0.1:8000/permission/checked', body, { headers });
        }
    }
