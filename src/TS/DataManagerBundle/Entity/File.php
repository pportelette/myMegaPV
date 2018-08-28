<?php

namespace TS\DataManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="TS\DataManagerBundle\Repository\FileRepository")
 */
class File
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
   * @ORM\OneToOne(targetEntity="TS\AssetsBundle\Entity\Site")
   */
    private $site;

    private $file;

    /**
     * Set file.
     *
     * @param string $file
     *
     * @return File
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
      // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
      if (null === $this->file) {
        return;
      }
  
      // On récupère le nom original du fichier de l'internaute
      $name = $this->file->getClientOriginalName();
  
      // On déplace le fichier envoyé dans le répertoire de notre choix
      $this->file->move($this->getUploadRootDir(), $name);
    }
  
    public function getUploadDir()
    {
      // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
      return 'cache/dev';
    }
  
    protected function getUploadRootDir()
    {
      // On retourne le chemin relatif vers l'image pour notre code PHP
      return __DIR__.'/../../../../var/'.$this->getUploadDir();
    }

    public function getName()
    {
        $name = $this->file->getClientOriginalName();

        return $name;
    }

    /**
     * Set site.
     *
     * @param \TS\AssetsBundle\Entity\Site $site
     *
     * @return Substation
     */
    public function setSite(\TS\AssetsBundle\Entity\Site $site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site.
     *
     * @return \TS\AssetsBundle\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
    }
}
