<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReclamationResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reclamation;

    public function __construct($reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $matiere = $this->reclamation->matiere->nom ?? 'Matière inconnue';
        $statut = ucfirst($this->reclamation->statut ?? 'inconnu');
        $reponse = $this->reclamation->reponse_admin ?? 'Aucune réponse';

        $anneeAcademiqueId = $this->reclamation->bulletin?->periode?->annee_academique_id;

        $url = $anneeAcademiqueId
            ? route('bulletins.show', ['annee_academique_id' => $anneeAcademiqueId])
            : '#'; // lien par défaut si null

        return (new MailMessage)
            ->subject('Réponse à votre réclamation')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre réclamation a été traitée. Voici les détails :')
            ->line('Matière : ' . $matiere)
            ->line('Statut : ' . $statut)
            ->line('Réponse : ' . $reponse)
            ->action('Voir le bulletin', $url)
            ->line('Merci pour votre confiance.')
            ->salutation('Cordialement,');
    }

    public function toArray($notifiable)
    {
        $matiere = $this->reclamation->matiere->nom ?? 'Matière inconnue';
        $statut = ucfirst($this->reclamation->statut ?? 'inconnu');
        $anneeAcademiqueId = $this->reclamation->bulletin?->periode?->annee_academique_id;

        return [
            'message' => 'Réponse à votre réclamation: ' . $statut,
            'link' => $anneeAcademiqueId
                ? route('bulletins.show', ['annee_academique_id' => $anneeAcademiqueId])
                : null,
            'type' => 'reclamation_response',
            'status' => $this->reclamation->statut ?? null,
            'subject' => $matiere,
        ];
    }
}
