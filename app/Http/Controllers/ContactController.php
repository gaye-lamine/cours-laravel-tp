<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
            // création du contact
        $contact = Contact::create($request->validated());
        // on va d'abord formaté les données:
            $contactFormatte = new ContactResource($contact);

        // return les données
        return response()->json([
            "status" => true,
            "data" => $contactFormatte,
            "message" => "contact créé avec sucess"
        ],201);
    }

    public function index()
    {
        $contacts =  Contact::all();
        $listcontacts = ContactResource::collection($contacts);
        return response()->json([
            "status" => true,
            "data" => $listcontacts,
            "message" => "la liste des contacts"
        ]);
    }

    // afficher un contact specifique

    public function show($id){
        $contact = Contact::findOrFail($id);
        return response()->json([
            "status" => true,
            "data" => new ContactResource($contact),
            "message" => "contact trouvé"
        ]);
    }

    public function update(ContactUpdateRequest $request, $id){
        $contact = Contact::findOrFail($id);
        $contact->update($request->validated());
        return response()->json([
            "status" => true,
            "data" => new ContactResource($contact),
            "message" => "contact modifié avec succès"
        ]);
    }

    // supprimer un contact
    public function destroy($id){
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json([
            "status" => true,
            "data" => new ContactResource($contact),
            "message" => "contact modifié avec succès"
        ],204);
    }
}
